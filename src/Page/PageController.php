<?php
namespace Cochran\Page;

use Cochran\Page;

class PageController
{
    public function __construct()
    {
        $this->page = new Page();
        $this->converter = new \League\CommonMark\CommonMarkConverter();
        $this->templates = new \League\Plates\Engine('../resources/views');
    }

    public function index()
    {
        echo 'list all pages';
    }

    public function create()
    {
        echo $this->templates->render('page/create');
    }

    public function store()
    {
        $this->page->create($_POST);
        header('Location: //page/create');
    }

    public function show($slug = 'home')
    {
        $page = $this->page->get($slug);
        if($page) {
            $page['content'] = $this->converter->convertToHtml($page['content']);
            echo $this->templates->render($slug, ['data' => $page]);
        } else {
            $data = array(
                'title' => '404 Page Not Found',
                'slug' => '404',
                'description' => '404 Page Not Found'
            );
            echo $this->templates->render('404', ['data' => $data]);
        }    
    }


}
