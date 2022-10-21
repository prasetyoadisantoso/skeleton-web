<?php

namespace App\Services;

enum Page: string {
    case HOME = 'Home Page';
    case INDEX = 'Index Page';
    case CREATE = 'Create Page';
    case DETAIL = 'Detail Page';
    case EDIT = 'Edit Page';
}

enum Login: string {
    case CLIENT = 'client';
    case ADMINISTRATOR = 'administrator';
}

class Enumeration
{
    public $homePage;
    public $indexPage;
    public $createPage;
    public $detailPage;
    public $editPage;
    public $client;
    public $administrator;

    public function __construct()
    {
        $this->homePage = Page::HOME;
        $this->indexPage = Page::INDEX;
        $this->createPage = Page::CREATE;
        $this->detailPage = Page::DETAIL;
        $this->editPage = Page::EDIT;
        $this->client = Login::CLIENT;
        $this->administrator = Login::ADMINISTRATOR;
    }
}
