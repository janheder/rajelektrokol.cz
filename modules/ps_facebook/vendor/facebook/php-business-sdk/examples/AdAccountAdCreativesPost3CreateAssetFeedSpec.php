<?php
/**
 * Copyright (c) 2015-present, Facebook, Inc. All rights reserved.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use
 * of this software is subject to the Facebook Developer Principles and
 * Policies [http://developers.facebook.com/policy/]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

require __DIR__ . '/vendor/autoload.php';

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdCreative;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

$access_token = '<ACCESS_TOKEN>';
$app_secret = '<APP_SECRET>';
$app_id = '<APP_ID>';
$id = '<AD_ACCOUNT_ID>';

$api = Api::init($app_id, $app_secret, $access_token);
$api->setLogger(new CurlLogger());

$fields = array(
);
$params = array(
  'name' => 'Dynamic Ad Creative with Asset Feed Spec Sample',
  'object_story_spec' => array('page_id' => '<pageID>'),
  'asset_feed_spec' => array('images' => array(array('hash' => '<imageHash>')),'bodies' => array(array('text' => 'Begin Your Adventure'),array('text' => 'Once a Trainer, always a Trainer.')),'titles' => array(array('text' => 'Level Up'),array('text' => 'Swipe to evolve')),'descriptions' => array(array('text' => 'First Dynamic Ad Creative Sample')),'ad_formats' => array('SINGLE_IMAGE'),'call_to_action_types' => array('SHOP_NOW'),'link_urls' => array(array('website_url' => 'https://www.example.com/')),'videos' => array()),
);
echo json_encode((new AdAccount($id))->createAdCreative(
  $fields,
  $params
)->exportAllData(), JSON_PRETTY_PRINT);