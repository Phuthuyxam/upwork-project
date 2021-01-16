<?php


namespace App\Modules\Client\Controllers;


use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PageTemplateConfigs;
use App\Core\Glosary\PostType;
use App\Http\Controllers\Controller;
use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\Taxonomy\Repositories\TermMetaRepository;
use App\Modules\Taxonomy\Repositories\TermRelationRepository;
use App\Modules\Taxonomy\Repositories\TermRepository;

class ClientPostController extends Controller
{

    protected $postRepository;
    protected $postMetaRepository;
    protected $termRepository;
    protected $termRelationRepository;
    protected $termMetaRepository;

    public function __construct(PostRepository $postRepository, PostMetaRepository $postMetaRepository,
                                TermRepository $termRepository, TermRelationRepository $termRelationRepository,
                                TermMetaRepository $termMetaRepository)
    {
        $this->postRepository = $postRepository;
        $this->postMetaRepository = $postMetaRepository;
        $this->termRepository = $termRepository;
        $this->termRelationRepository = $termRelationRepository;
        $this->termMetaRepository = $termMetaRepository;
    }

    public function detail($slug){
        if ($this->postRepository->getBySlug($slug)) {
            $translationMode = [ "mode" => "post" , "slug" => $slug ];
            $post = $this->postRepository->getBySlug($slug);
            $postMeta = $this->postMetaRepository->getByPostId($post->id);
            $postMetaMap = [];
            foreach ($postMeta as $value) {
                $postMetaMap[MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
            }

            if (isset($postMetaMap[MetaKey::PAGE_TEMPLATE['NAME']])) {
                $template = $postMetaMap[MetaKey::PAGE_TEMPLATE['NAME']];
                $pageMeta = $this->postMetaRepository->getByPostId($post->id);
                $pageMetaMap = [];
                if ($pageMeta) {
                    foreach ($pageMeta->toArray() as $value) {
                        $pageMetaMap[MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
                    }
                }
                if ($template == PageTemplateConfigs::ABOUT['VALUE']) {
                    $imageMap = [];
                    if (isset($pageMetaMap[MetaKey::IMAGE_ITEM['NAME']]) && !empty($pageMetaMap[MetaKey::IMAGE_ITEM['NAME']])){
                        $imageItem = $pageMetaMap[MetaKey::IMAGE_ITEM['NAME']];
                        $indexImage = $pageMetaMap[MetaKey::INDEX_IMAGE_ITEM['NAME']];
                        $index = $indexImage[0];
                        foreach ($indexImage as $k => $value) {
                            foreach ($imageItem as $key => $item) {
                                if (!array_key_exists($k, $imageMap) || count($imageMap[$k]) < intval($value)) {
                                    $imageMap[$k][] = $item;
                                    unset($imageItem[$key]);
                                } else {
                                    break;
                                }
                            }
                        }
                    }

                    $itemMap = [];
                    if (isset($pageMetaMap[MetaKey::INDEX_COMPLETE_ITEM['NAME']]) && !empty($pageMetaMap[MetaKey::INDEX_COMPLETE_ITEM['NAME']])) {
                        $items = $pageMetaMap[MetaKey::COMPLETE_ITEM['NAME']];
                        $indexItem = $pageMetaMap[MetaKey::INDEX_COMPLETE_ITEM['NAME']];
                        foreach ($indexItem as $k => $value) {
                            foreach ($items as $key => $item) {
                                if (!array_key_exists($k, $itemMap) || count($itemMap[$k]) < intval($value)) {
                                    $itemMap[$k][] = $item;
                                    unset($items[$key]);
                                } else {
                                    break;
                                }
                            }
                        }
                    }
                    return view('Client::about',compact('post','pageMetaMap','imageMap','itemMap', 'translationMode'));
                }
                if ($template == PageTemplateConfigs::SERVICE['VALUE']) {
                    return view('Client::service',compact('post','pageMetaMap','translationMode'));
                }
                if ($template == PageTemplateConfigs::HOTEL['VALUE']) {
                    $posts = $this->postRepository->getInstantModel()->where('post_type',PostType::POST['VALUE'])->get();
                    $ids = [];
                    $postsMetaMap = [];
                    if (count($posts)) {
                        foreach ($posts->toArray() as $value) {
                            $ids[] = $value['id'];
                            $postsMetaMap[$value['id']] = [
                                'title' => $value['post_title'],
                                'slug' => $value['post_name']
                            ];
                        }
                    }

                    $postMetas = $this->postMetaRepository->findByPostIds($ids);
                    if (count($postMetas)) {
                        foreach ($postsMetaMap as $key => $item) {
                            foreach ($postMetas->toArray() as $value) {
                                if ($key == $value['post_id']) {
                                    if (isset($value['meta_key'])) {
                                        $postsMetaMap[$key][MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
                                    }
                                }
                            }
                        }
                    }
                    return view('Client::hotel',compact('post','postsMetaMap','pageMetaMap','translationMode'));
                }
                if ($template == PageTemplateConfigs::DEFAULT['VALUE']) {
                    return view('Client::hotel',compact('post','pageMetaMap', 'translationMode'));
                }
            }else {
                $termRelation = $this->termRelationRepository->getInstantModel()->where('object_id', $post->id)->first();
                $termMeta = $this->termMetaRepository->getInstantModel()->where('term_id', $termRelation->term_taxonomy_id)->get();
                $termMetaMap = [];
                if ($termMeta) {
                    foreach ($termMeta->toArray() as $value) {
                        $termMetaMap[MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
                    }
                }

                $relatePost = $this->termRelationRepository->getInstantModel()->where('term_taxonomy_id', $termRelation->term_taxonomy_id)->get();
                $ids = [];
                if ($relatePost) {
                    $relatePost = $relatePost->toArray();
                    foreach ($relatePost as $value) {
                        if ($value['object_id'] != $post->id) {
                            $ids[] = $value['object_id'];
                        }
                    }
                }
                $relatePostMap = [];
                $relatePostMetaMap = [];
                $relatePosts = $this->postRepository->findByIds($ids);
                if (count($relatePosts)) {
                    $relatePostMap = $relatePosts->toArray();
                    foreach ($relatePostMap as $key => $value) {
                        $relatePostMetaMap[$value['id']] = [
                            'slug' => $value['post_name'],
                            'title' => $value['post_title'],
                        ];
                    }
                }

                $relatePostMeta = $this->postMetaRepository->findByPostIds($ids);

                if (count($relatePostMeta)) {
                    $relatePostMeta = $relatePostMeta->toArray();
                    foreach ($relatePostMetaMap as $key => $value) {
                        foreach ($relatePostMeta as $k => $meta) {
                            if ($key == $meta['post_id']) {
                                if (isset($meta['meta_key'])) {
                                    $relatePostMetaMap[$key][MetaKey::display($meta['meta_key'])] = json_decode($meta['meta_value']);
                                }
                            }
                        }
                    }
                }

                return view('Client::hotel-detail', compact('post', 'postMetaMap', 'termMetaMap', 'relatePostMetaMap', 'relatePostMap', 'translationMode'));
            }
        }else{
            return view('Client::pages.404');
        }
    }
}
