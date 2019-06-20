<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 14/11/2017
 * Time: 08:58
 */

namespace FredBradley\NewsArticleFooter;

/**
 * Class Plugin
 *
 * @package FredBradley\NewsArticleFooter
 */
class Plugin
{

    /**
     * @var string
     */
    private $footerHTML = '';
    /**
     * @var string
     */
    private $facebookURI = 'https://www.facebook.com/CranPrep';
    /**
     * @var string
     */
    private $twitterURI = 'https://twitter.com/CranleighPrep';

    /**
     * Plugin constructor.
     */
    public function __construct()
    {
        new PluginUpdateCheck('cranleigh-news-article-footer');

        $settings         = new Settings();
        $this->footerHTML = $this->formatFooterHtml();
        add_filter('the_content', [ $this, 'add_my_content' ]);
    }

    /**
     * @return string
     */
    private function formatFooterHtml()
    {

        $this->footerHTML = strip_tags($this->getSetting('footer_text'));

        $text = $this->formatUriLink('facebook', 'Facebook');
        $text = $this->formatUriLink('twitter', 'Twitter');

        return $text;
    }

    /**
     * @param string $setting
     *
     * @return mixed|bool
     */
    private function getSetting( string $setting )
    {

        $option = get_option('news_article_settings');

        if (isset($option[ $setting ]) ) {
            return $option[ $setting ];
        }

        return false;
    }

    /**
     * @param string $type
     * @param string $searchTerm
     *
     * @return string
     */
    private function formatUriLink( string $type, string $searchTerm )
    {

        $this->setURIVariable($type);
        $link             = '<a data-event-category="true" data-category="NewsFooter" data-action="Click" data-label="' . $type . '" href="' . $this->{$type . 'URI'} . '" target="_blank"><i class="fa fa-fw fa-' . $type . '"></i>' . ucwords($searchTerm) . '</a>';
        $this->footerHTML = str_replace($searchTerm, $link, $this->footerHTML);

        return $this->footerHTML;
    }

    /**
     * @param string $type
     */
    private function setURIVariable( string $type )
    {

        $setting = strtolower($type) . 'URI';
        if (null != $this->getSetting($setting) ) {
            $this->$setting = $this->getSetting($setting);
        }
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public function add_my_content( string $content )
    {

        if (is_single() && get_post_type() === 'post' ) {
            $content .= '<div class="pull-out news-article-footer-promo">' . wpautop($this->footerHTML) . '</div>';
        }

        return $content;
    }

}
