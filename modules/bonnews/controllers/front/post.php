<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Frequently Asked Questions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2020 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

class BonnewsPostModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->context = Context::getContext();
        $this->id_shop = Context::getContext()->shop->id;

        
        $result = array();
        
        $post = new ClassBonnews(
            (int)Tools::getValue('id_tab'),
            (int)$this->context->language->id,
            (int)$this->context->shop->id
        );
       
        $breadcrumb = $this->getBreadcrumbLinks();

        $prevNextPost = $this->prevNextPost();

        $result['title'] = $post->title;
        $result['url'] = str_replace(' ', '_', $post->url);
        $result['description'] = $post->description;
        $result['content_post'] = $post->content_post;
        $result['date_post'] = $post->date_post;
        $result['image'] = $post->image;
        $result['type'] = $post->type;
        $result['cover'] = $post->cover;
        $result['id'] = $post->id;
        $result['author_name'] = $post->author_name;
        $result['author_img'] = $post->author_img;
        
        if (Configuration::get('BON_ADD_DISQUS')) {
            $this->context->smarty->assign(array(
                'add_disqus'=> Configuration::get('BON_ADD_DISQUS'),
                'disqus_name'=> Configuration::get('DISQUS_SHORT_NAME')
            ));
        }
 
        $this->context->smarty->assign(array(
            'display_carousel' => Configuration::get('BON_NEWS_DISPLAY_CAROUSEL'),
            'image_baseurl'=> _MODULE_DIR_.'bonnews/views/img/',
            'limit'=> Configuration::get('BON_NEWS_LIMIT'),
            'add_sharebuttons'=> Configuration::get('BON_ADD_SHAREBUTTONS'),
            'post'=> $result,
            'prevNextPost'=> $prevNextPost,
        ));
        $this->setTemplate('module:bonnews/views/templates/front/bonnews_post.tpl');
    }

    public function prevNextPost()
    {
        $result = array();

        $next_post = new ClassBonnews(
            (int)Tools::getValue('id_tab') + 1,
            (int)$this->context->language->id,
            (int)$this->context->shop->id
        );
        
        $prev_post = new ClassBonnews(
            (int)Tools::getValue('id_tab') - 1,
            (int)$this->context->language->id,
            (int)$this->context->shop->id
        );
        
        $result['next_id'] = $next_post->id;
        $result['prev_id'] = $prev_post->id;
        $result['url_next'] = str_replace(' ', '_', $next_post->url);
        $result['url_prev'] = str_replace(' ', '_', $prev_post->url);

        return $result;
    }

    public function getBreadcrumbLinks()
    {
        $post = new ClassBonnews(
            (int)Tools::getValue('id_tab'),
            (int)$this->context->language->id,
            (int)$this->context->shop->id
        );

        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['count'] = 3;
        $breadcrumb['links'][] = array(
            'title' => $this->l('News'),
            'url' => $this->context->link->getModuleLink(
                'bonnews',
                'main'
            ),
        );
        $breadcrumb['links'][] = array(
            'title' => $post->title,
            'url' => $this->context->link->getModuleLink(
                'bonnews',
                'post',
                ['id_tab'=> $post->id, 'link_rewrite'=> str_replace(' ', '_', $post->url)]
            ),
        );
        return $breadcrumb;
    }
}
