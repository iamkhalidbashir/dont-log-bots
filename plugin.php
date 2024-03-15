<?php
/**
Plugin Name: Don't Log Bots
Plugin URI: https://github.com/YOURLS/dont-log-bots
Description: Do not log some bots in stats
Version: 1.3
Author: Ozh, Leo Colomb, Suguru Hirahara
Author URI: http://yourls.org
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Check current user-agent against a list of bots, return boolean
function yp_dlb_is_bot() {
    // Get current User-Agent
    $current = strtolower( $_SERVER['HTTP_USER_AGENT'] );
        
    // Array of known bot lowercase strings
    // Example: 'googlebot' will match 'Googlebot/2.1 (+http://www.googlebot.com/bot.html)'
    $bots = array(
        // List of Active crawlers & bots since October 2013 (imcomplete)
        // picked up from: http://user-agent-string.info/list-of-ua/bots
        // also: http://myip.ms/browse/web_bots/Known_Web_Bots_Web_Bots_2014_Web_Spider_List.html
        '200please.com/bot',
        '360spider',
        '80legs.com/webcrawler',
        'a6-indexer',
        'aboundex',
        'aboutusbot',
        'addsearchbot',
        'addthis.com',
        'adressendeutschland.de',
        'adsbot-google',
        'ahrefsbot',
        'aihitbot',
        'alexa site audit',
        'amznkassocbot',
        'analyticsseo.com',
        'antbot',
        'arabot',
        'archive.org_bot',
        'archive.orgbot',
        'askpeterbot',
        'backlinkcrawler',
        'baidu.com/search/spider.html',
        'baiduspider',
        'begunadvertising',
        'bingbot',
        'bingpreview',
        'bitlybot',
        'bixocrawler',
        'blekkobot',
        'blexbot',
        'brainbrubot',
        'browsershots',
        'bubing',
        'butterfly',
        'bufferbot',
        'careerbot',
        'catchbot',
        'ccbot',
        'cert figleafbot',
        'changedetection.com/bot.html',
        'chilkat',
        'claritybot',
        'classbot',
        'cliqzbot',
        'cms crawler',
        'coccoc',
        'compspybot',
        'crawler4j',        
        'crowsnest',
        'crystalsemanticsbot',
        'dataminr.com',
        'daumoa',
        'easouspider',
        'exabot',
        'exb language crawler',
        'ezooms',
        'facebookexternalhit',
        'facebookplatform',
        'fairshare',
        'feedfetcher',
        'feedly.com/fetcher.html',
        'feedlybot',
        'fetch',
        'flipboardproxy',
        'fyberspider',
        'genieo',
        'gigabot',
        'google page speed insights',
        'googlebot',
        'grapeshot',
        'hatena-useragent',
        'hubspot connect',
        'hubspot links crawler',
        'hosttracker.com',
        'ia_archiver',
        'icc-crawler',
        'ichiro',
        'immediatenet.com',
        'iltrovatore-setaccio',
        'infohelfer',
        'instapaper',
        'ixebot',
        'jabse.com crawler',
        'james bot',
        'jikespider',
        'jyxobot',
        'linkdex',
        'linkfluence',
        'loadimpactpageanalyzer',
        'luminate.com',
        'lycosa',
        'magpie-crawler',
        'mail.ru_bot',
        'meanpathbot',
        'mediapartners-google',
        'metageneratorcrawler',
        'metajobbot',
        'mj12bot',
        'mojeekbot',
        'msai.in',
        'msnbot-media',
        'musobot',
        'najdi.si',
        'nalezenczbot',
        'nekstbot',
        'netcraftsurveyagent',
        'netestate ne crawler',
        'netseer crawler',
        'nuhk',
        'obot',
        'omgilibot',
        'openwebspider',
        'panscient.com',
        'parsijoo',
        'plukkie',
        'proximic',
        'psbot',
        'qirina hurdler',
        'qualidator.com',
        'queryseekerspider',
        'readability',
        'rogerbot',
        'sbsearch',
        'scrapy',
        'search.kumkie.com',
        'searchbot',
        'searchmetricsbot',
        'semrushbot',
        'seocheckbot',
        'seoengworldbot',
        'seokicks-robot',
        'seznambot',
        'shareaholic.com/bot',
        'shopwiki.com/wiki/help:bot',
        'showyoubot',
        'sistrix',
        'sitechecker',
        'siteexplorer',
        'speedy spider',
        'socialbm_bot',
        'sogou web spider',
        'sogou',
        'sosospider',
        'spbot',
        'special_archiver',
        'spiderling',
        'spinn3r',
        'spreadtrum',
        'steeler',
        'suma spider',
        'surveybot',
        'suggybot',
        'svenska-webbsido',
        'teoma',
        'thumbshots',
        'tineye.com',
        'trendiction.com',
        'trendiction.de/bot',
        'turnitinbot',
        'tweetedtimes bot',
        'tweetmeme',
        'twitterbot',
        'uaslinkchecker',
        'umbot',
        'undrip bot',
        'unisterbot',
        'unwindfetchor',
        'urlappendbot',
        'vedma',
        'vkshare',
        'voilabot',
        'wbsearchbot',
        'wch web spider',
        'webcookies',
        'webcrawler at wise-guys dot nl',
        'webthumbnail',
        'wesee:search',
        'woko',
        'woobot',
        'woriobot',
        'wotbox',
        'y!j-bri',
        'y!j-bro',
        'y!j-brw',
        'y!j-bsc',
        'yacybot',
        'yahoo! slurp',
        'yahooysmcm',
        'yandexbot',
        'yats',
        'yeti',
        'yioopbot',
        'yodaobot',
        'youdaobot',
        'zb-1',
        'zeerch.com/bot.php',
        'zing-bottabot',
        'zumbot',

        // accessed when tweeted
        'ning/1.0',
        'yahoo:linkexpander:slingstone',
        'google-http-java-client/1.17.0-rc (gzip)',
        'js-kit url resolver',
        'htmlparser',
        'paperlibot',
        
        // xenu
        'xenu link sleuth',

        // Custom
        'awariosmartbot',
        'amazonbot',
        'redditbot',
        'redditbot',
        'dataforseobot',
        'mattermost-bot',
    );
        
    // Check if the current UA string contains a know bot string
    $is_bot = ( str_replace( $bots, '', $current ) != $current );
        
    return $is_bot;
}

// Hook stuff in
yourls_add_filter( 'shunt_update_clicks', 'yp_dlb_skip_if_bot' );
yourls_add_filter( 'shunt_log_redirect', 'yp_dlb_skip_if_bot' );

// Skip if it's a bot
function yp_dlb_skip_if_bot() {
    return yp_dlb_is_bot();
    // if anything but false is returned, functions using the two shunt_* filters will be short-circuited
}
