/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

import $ from 'jquery'

import 'bootstrap'

const routes = require('../public/js/fos_js_routes.json');
import Routing from '../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

const Url = {
    prefix: function(url) {
        return '/symfony_blog/public/index.php' + url
    }
}

$(document).ready(function() {
    $('button.js-add-file-row-btn').on('click', function (element) {
        var fileInputWrapper = $(element.target).closest('fieldset.form-group').find('div.input-row-wrapper')
        // 获取当前input行计数
        var inputCount = fileInputWrapper.children().length
        // 获取input prototype并进行序号修改
        var inputCode = fileInputWrapper.data('prototype')
        console.log(inputCount)
        console.log(inputCode)
        inputCode = inputCode.replace(/__name__/g, inputCount)
        fileInputWrapper.append(inputCode)
    })

    // 回复评论
    $('button.js-replay-comment-btn').on('click', function(element) {
        let postId = $(this).data('post-id');
        let parentCommentId = $(this).data('parent-id')
        let url = Routing.generate('reply_comment', {post_id: postId, comment_id: parentCommentId})

        if ($(this).nextAll('p.max-level-info').length === 1) {
            return;
        }

        if ($(this).nextAll('div.reply-comment-card').length === 0) {
            // url =  + url
            $.ajax({
                url: Url.prefix(url),
                type: 'POST'
            }).done(function(response) {
                $(element.target).after(response)
            }).fail(function(jqXHR) {

            })
        }
    })
})