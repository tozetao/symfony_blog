<?php

namespace App\Tests\FunctionalTest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostDetailTest extends WebTestCase
{
    public function testCommentSubmit(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

//        $link = $crawler->selectLink('Read More →')->link();
//        $pageDetailCrawler = $client->click($link);
//
//        $this->assertResponseIsSuccessful();
//
//        $form = $pageDetailCrawler->selectButton('Submit')->form();
//        $form['comment[author]'] = 'zhangsan';
//        $form['comment[email]'] = 'zhangsan@163.com';
//        $form['comment[content]'] = 'zhangsan content';
//        $client->submit($form);
//
//        $this->assertResponseIsSuccessful();
//        $this->assertStringContainsString('zhangsan', $client->getResponse()->getContent());
//        $this->assertStringContainsString('zhangsan@163.com', $client->getResponse()->getContent());
    }

    /*
     * DomCrawler组件可以对HTML页面上的DOM元素进行过滤和抓取。
     *
     * crawler对象在抓取某些元素后，client对象可以利用它来执行DOM元素的事件。
     * 比如点击链接、提交表单等。最后通过DOM事件的响应来查看页面的显示结果是不是符合我们的预期。
     *
     *
     * php .\bin\console make:test
     * php .\bin\phpunit --filter=testCommentSubmit
     */
}
