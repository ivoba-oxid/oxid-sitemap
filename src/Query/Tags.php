<?php

namespace IvobaOxid\OxidSiteMap\Query;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class Tags
 * @package IvobaOxid\OxidSiteMap\Query
 */
class Tags extends AbstractQuery
{
    public function getQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->select('oxseourl, oxstdurl')
            ->from('oxseo')
            ->where(
                "oxseourl <> ''",
                'oxstdurl LIKE :controller',
                'oxtype = :type',
                'oxexpired = 0'
            )
            ->andWhere('oxlang IN (:langIds)')
            ->setParameters([
                'controller' => '%%=oetagstagcontroller%%',
                'type'       => 'dynamic',
                'langIds'    => implode(',', $this->config->getLangIds()),
            ]);

        return $queryBuilder;
    }

    /**
     * @return array
     */
    public function getPages()
    {
        $pages         = [];
        $query         = $this->getQuery($this->queryBuilderFactory->create());
        $result        = $query->execute()->fetchAll();
        $sViewName     = 'oxartextends';
        $sArticleTable = 'oxarticles';
        if ($result !== false) {
            foreach ($result as $item) {
                $url       = $item['oxstdurl'];
                $urlParsed = parse_url($url);
                if (isset($urlParsed['query'])) {
                    parse_str(html_entity_decode($urlParsed['query']), $urlQuery);
                    $oTag = oxNew('oetagstag', $urlQuery['searchtag']);
                    $oTag->addUnderscores();
                    $sTag     = $oTag->get();
                    $queryTag = $this->queryBuilderFactory->create();
                    $queryTag
                        ->select("{$sViewName}.oxid")
                        ->from($sViewName)
                        ->innerJoin(
                            $sViewName,
                            "",
                            $sArticleTable,
                            "{$sArticleTable}.oxid = {$sViewName}.oxid where {$sArticleTable}.oxparentid = '' and " .
                            "{$sArticleTable}.oxactive = 1 and " .
                            "({$sViewName}.oetags like :tag" .
                            " or {$sViewName}.oetags like :tagMiddle" .
                            " or {$sViewName}.oetags like :tagEnd" .
                            " or {$sViewName}.oetags like :tagFirst)"
                        )
                        ->setParameters(
                            [
                                'tag'       => $sTag,
                                'tagMiddle' => '%,' . $sTag . ',%',
                                'tagEnd'    => '%,' . $sTag,
                                'tagFirst'  => $sTag . ',%',
                            ]
                        );
                    $resTag = $queryTag->execute()->fetchAll();
                    if ($resTag !== false && count($resTag) > 0) {
                        $pages[] = $this->createPage($item);
                    }
                }
            }
        }

        return $pages;
    }
}
