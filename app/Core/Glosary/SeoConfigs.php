<?php


namespace App\Core\Glosary;


class SeoConfigs extends BasicEnum
{
    const SEOTYPE = [
        'COMMON' => [ 'KEY' => 'seo.common' ],
        'SINGLE' => ['KEY' => 'seo.single'],
        'GROUP' => ['KEY' => 'seo.group']
    ];

    const SEOKEY = [
        'SEO' => [
            'FOCUS_KEYPHARE' => 'seo_focus_keyphrase',
            'TITLE' => 'seo_meta_title',
            'DESC' => 'seo_meta_description',
            'CORNERSTONE_CONTENT' => 'seo_cornerstone_content',
            'SHOW_POST_IN_SEARCH' => 'seo_show_post_search',
            'FOLLOW_LINK_POST' => 'seo_follow_post',
            'ROBOTS_ADVANCED_NO_IMAGE' => 'seo_robots_advance_no_image',
            'ROBOTS_ADVANCED_NO_ARCHIVE' => 'seo_robots_advance_no_archive',
            'ROBOTS_ADVANCED_NO_SNIPPET' => 'seo_robots_advance_no_snippet',
            'CANONICAL_URL' => 'seo_canonical_url'
            ],
        'SCHEMA' => [
            'PAGE_TYPE' => 'seo_page_type',
            'ARTICLE_TYPE' => 'seo_article_type'
        ],
        'SOCIAL' => [
            'FACEBOOK' => [
                'IMAGE' => 'seo_facebook_image',
                'TITLE' => 'seo_facebook_title',
                'DESCRIPTION' => 'seo_facebook_desc'
            ],
            'TWITTER' => [
                'IMAGE' => 'seo_twitter_image',
                'TITLE' => 'seo_twitter_title',
                'DESCRIPTION' => 'seo_twitter_desc'
            ]
        ]
    ];

    public static function getSeoKey() {
        return self::SEOKEY;
    }
}
