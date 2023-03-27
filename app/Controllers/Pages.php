<?php

namespace App\Controllers;

class Pages extends BaseController
{
    
    public function view($page = 'home')
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        $data['title'] = ucfirst($page); 

        return view('common/header', $data)
            . view('pages/' . $page)
            . view('common/footer');
    }
}
