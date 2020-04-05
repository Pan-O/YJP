//一言
if (J.hitokoto == '1' && J.is_home ){
fetch('https://v1.hitokoto.cn')
    .then(response => response.json())
    .then(data => {
      const hitokoto = document.getElementById('hitokoto')
      hitokoto.innerText = data.hitokoto
    })
    .catch(console.error)
} else if  (J.hitokoto == '1' && J.singular_post_open ){
fetch('https://v1.hitokoto.cn')
    .then(response => response.json())
    .then(data => {
      const hitokoto = document.getElementById('hitokoto')
      hitokoto.innerText = data.hitokoto
    })
    .catch(console.error)
} 
//上传图片
if (J.singular_open && J.comment_open && J.comment_img == '1'){
var textarea = document.getElementById('comment')
var button = document.getElementById('comment_add_img')
button.addEventListener('click', () => {
  var value = textarea.value.split('')
  var pos = textarea.selectionStart
  var img = prompt("输入图片链接","");
  var insertValue = img
  value.splice(pos, 0, insertValue)
  textarea.value = value.join('')
  textarea.selectionStart = textarea.selectionEnd = pos + insertValue.length
  textarea.focus()
}, false)
}
//ajax评论发表
jQuery(document).ready(function(jQuery) {
	var __cancel = jQuery('#cancel-comment-reply-link'),
		__cancel_text = __cancel.text(),
		__list = 'comment-list';
	jQuery(document).on("submit", "#commentform", function() {
		jQuery.ajax({
			url: J.ajax_url,
			data: jQuery(this).serialize() + "&action=ajax_comment",
			type: jQuery(this).attr('method'),
			beforeSend: faAjax.createButterbar("提交中...."),
			error: function(request) {
				var t = faAjax;
				t.createButterbar(request.responseText);
			},
			success: function(data) {
				jQuery('textarea').each(function() {
					this.value = ''
				});
				var t = faAjax,
					cancel = t.I('cancel-comment-reply-link'),
					temp = t.I('wp-temp-form-div'),
					respond = t.I(t.respondId),
					post = t.I('comment_post_ID').value,
					parent = t.I('comment_parent').value;
				if (parent != '0') {
					jQuery('#respond').before('<ol class="children">' + data + '</ol>');
				} else if (!jQuery('.' + __list ).length) {
					if (J.formpostion == 'bottom') {
						jQuery('#respond').before('<ol class="' + __list + '">' + data + '</ol>');
					} else {
						jQuery('#respond').after('<ol class="' + __list + '">' + data + '</ol>');
					}

				} else {
					if (J.order == 'asc') {
						jQuery('.' + __list ).append(data);
					} else {
						jQuery('.' + __list ).prepend(data); 
					}
				}
				t.createButterbar("提交成功");
				cancel.style.display = 'none';
				cancel.onclick = null;
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp)
				}
			}
		});
		return false;
	});
	faAjax = {
		I: function(e) {
			return document.getElementById(e);
		},
		clearButterbar: function(e) {
			if (jQuery(".ajax-message").length > 0) {
				jQuery(".ajax-message").remove();
			}
		},
		createButterbar: function(message) {
			var t = this;
			t.clearButterbar();
			jQuery("body").append('<div class="ajax-message ajax-comment-center"><p class="ajax-message--main">' + message + '</p></div>');
			setTimeout("jQuery('.ajax-message').remove()", 3000);
		}
	};
});
/**
 消息提示组件
**/
$.extend({
  message: function(options) {
      var defaults={
          message:' 操作成功',
          time:'2000',
          showClose:false,
          autoClose:true,
          onClose:function(){}
      };
      if(typeof options === 'string'){
          defaults.message=options;
      }
      if(typeof options === 'object'){
          defaults=$.extend({},defaults,options);
      }
      var template='<div class="c-message messageFadeInDown">'+
          '<div class="c-message--main">' +
            '<div class="c-message--tip">'+defaults.message+'</div>'+
          '</div>'+
      '</div>';
      var _this=this;
      var $body=$('body');
      var $message=$(template);
      var timer;
      var closeFn,removeFn;
      closeFn=function(){
          $message.addClass('messageFadeOutUp');
          $message.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
              removeFn();
          })
      };
      removeFn=function(){
          $message.remove();
          defaults.onClose(defaults);
          clearTimeout(timer);
      };
      $('.c-message').remove();
      $body.append($message);
      $message.css({
          'margin-left':'-'+$message.width()/2+'px'
      })
      $message.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
          $message.removeClass('messageFadeInDown');
      });
      if(defaults.autoClose){
          timer=setTimeout(function(){
              closeFn();
          },defaults.time)
      }
  }
});
//夜间模式
function NightMode(){
    var night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if(night == '0'){
        document.body.classList.add('night');
        document.cookie = "night=1;path=/"
		$.message('夜间模式开启');
    }else{
        document.body.classList.remove('night');
        document.cookie = "night=0;path=/"
		$.message('夜间模式关闭');
    }
}
//表情（来自wp-alu插件）
document.addEventListener('DOMContentLoaded', function(){
   var aluContainer = document.querySelector('.comment-form-smilies');
    if ( !aluContainer ) return;
    aluContainer.addEventListener('click',function(e){
    var myField,
        _self = e.target.dataset.smilies ? e.target : e.target.parentNode;
        if ( typeof _self.dataset.smilies == 'undefined' ) return;
        var tag = ' ' + _self.dataset.smilies + ' ';
        if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
            myField = document.getElementById('comment')
        } else {
            return false
        }
        if (document.selection) {
            myField.focus();
            sel = document.selection.createRange();
            sel.text = tag;
            myField.focus()
        } else if (myField.selectionStart || myField.selectionStart == '0') {
            var startPos = myField.selectionStart;
            var endPos = myField.selectionEnd;
            var cursorPos = endPos;
            myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length);
            cursorPos += tag.length;
            myField.focus();
            myField.selectionStart = cursorPos;
            myField.selectionEnd = cursorPos
        } else {
            myField.value += tag;
            myField.focus()
        }
    });
 });
$('body').on('click','.comment-addsmilies',
function(){
    $('.comment-form-smilies').fadeToggle(400);
});
//分享
$('body').on('click','.share_button',
function(){
    $('.share_show').fadeToggle(400);
});
//ajax加载文章
  $("#pagination a").on("click", function(){
    $(this).addClass("").text("加载中");
    $('.cp-spinner').slideDown();
    $.ajax({
  type: "POST",
      url: $(this).attr("href"),
                 success: function(data){
                        result = $(data).find(".main-content .post-item");
                        nextHref = $(data).find("#pagination a").attr("href");
                        $(".main-content").append(result.fadeIn(500));
                        $("#pagination a").removeClass("loading").text("下一页");
                        if ( nextHref != undefined ) {
                            $("#pagination a").attr("href", nextHref);
                        } else {
                            $("#pagination").html("<span>没有了啊！</span>");
                        }
        
      }
    });
    return false;
  });
//ajax评论分页
 $body=(window.opera)?(document.compatMode=="CSS1Compat"?$('html'):$('body')):$('html,body');
        $('body').on('click', '.comments-pagination a', function(e){
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: $(this).attr('href'),
                beforeSend: function(){
                    $('.comments-pagination').remove();
                    $('ol.comment-list').remove();
                    $('#loading-comments').slideDown();
                    $body.animate({
											scrollTop: $('.comments-title').offset().top - 65
										}, 800 );
                },
                dataType: "html",
                success: function(out){
                    result = $(out).find('ol.comment-list');
                    nextlink = $(out).find('.comments-pagination');
                    $('#loading-comments').slideUp('fast');
                    $('#loading-comments').after(result.fadeIn(500));
                    $('ol.comment-list').after(nextlink);
                }
            });
        });
//点赞
$.fn.postLike = function() {
	if ($(this).hasClass('done')) {
		$.message('你已经赞过了！');
		return false;
	} else {
	    $.message('点赞成功');
		$(this).addClass('done');
		var id = $(this).data("id"),
		action = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: action
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};
$(document).on("click", ".specsZan",
	function() {
		$(this).postLike();
});
//展开 / 收缩功能
(function() {
	$(function(){
		$('.xHeading').on('click', function(event){
			var $this = $(this);
			$this.closest('.xControl').find('.xContent').slideToggle(300);
			if ($this.closest('.xControl').hasClass('active')) {
				$this.closest('.xControl').removeClass('active');
			} else {
				$this.closest('.xControl').addClass('active');
			}
			event.preventDefault();
		});
	});
}());
//代码高亮
if (J.singular_open){
hljs.initHighlightingOnLoad();
}
//返回顶部
$(function(){
        $(window).on("scroll", function() {
		var t = $(this).scrollTop();
		t>200?$(".back2top").addClass("is-active") : $(".back2top").removeClass("is-active")
	}), $(document).on("click", ".back2top", function() {
		$("html,body").animate({
			scrollTop: 0
		}, 800)
	});
});
//二维码
if (J.qrcode == '1' && J.singular_post_open){
$(function(){
	var home = window.location.href;
var qrcode = new QRCode("wechat_share_qrcode", {
	text:  home,
	width: 128,
	height: 128,
	colorDark : "#000000",
	colorLight : "#ffffff",
	correctLevel : QRCode.CorrectLevel.H
});
});
}