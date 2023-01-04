<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryTest extends TestCase
{
    public function user_auth()
    {
        return Auth::attempt(['email' => 'superadmin@email.com', 'password' => '123456']);
    }

    public function locale()
    {
        return LaravelLocalization::setLocale('id');
    }

    public function test_category_index_page()
    {
        $this->getJson(route('category.index'), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_category_index_datatable()
    {
        $this->getJson(route('category.datatable'), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_category_create_page()
    {
        $this->getJson(route('category.create'), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_category_store()
    {
        $this->postJson(route('category.store'),[
            'name' => '<?php echo "Hai";?>',
            'slug' => 'mix-categorized',
            'parent' => 'b2bf09b5-a424-4cb6-8a9c-7e1eba80589c',
        ], [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_category_edit()
    {
        // $categorydata = new Category;
        // $data = $categorydata->query()->first();
        $this->getJson(route('category.edit', '098f5eaf-7c45-47bb-80b3-a2fb32e3977a'), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_category_update()
    {
        // $tagdata = new Tag;
        // $data = $tagdata->query()->first();
        $this->putJson(route('category.update', '098f5eaf-7c45-47bb-80b3-a2fb32e3977a'),[
            'name' => 'My Mix Category',
            'slug' => '',
            'parent' => 'a1557c06-32a2-4797-8656-0c59f37b39a7'
        ], [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_category_delete()
    {
        // $tagdata = new Tag;
        // $data = $tagdata->query()->first();
        $this->deleteJson(route('category.destroy', 'a1557c06-32a2-4797-8656-0c59f37b39a7'), [], [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

}
