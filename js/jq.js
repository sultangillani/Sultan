$(document).ready(function(){
    
    /*********************************Responsive Options******************************/
    var pageY = $(this).width();
    if(pageY < 992){
        $('#cont').removeClass('container');
        $('#cont').addClass('container-fluid');
    }else{
        $('#cont').addClass('container');
        $('#cont').removeClass('container-fluid');
    }
    
    if (pageY <= 400) {
        $('.search').removeClass('col-xs-offset-2');
        $('.search').removeClass('col-xs-8');
        $('.search').addClass('col-xs-12');
    }else{
        $('.search').addClass('col-xs-offset-2');
        $('.search').removeClass('col-xs-12');
        $('.search').addClass('col-xs-8');
    }
    
    $(window).resize(function(){
        var pageY = $(this).width();
        if(pageY < 992){
            $('#cont').removeClass('container');
            $('#cont').addClass('container-fluid');
        }else{
            $('#cont').addClass('container');
            $('#cont').removeClass('container-fluid');
        }
        
        if (pageY <= 400) {
            $('.search').removeClass('col-xs-offset-2');
            $('.search').removeClass('col-xs-8');
            $('.search').addClass('col-xs-12');
        }else{
            $('.search').addClass('col-xs-offset-2');
            $('.search').removeClass('col-xs-12');
            $('.search').addClass('col-xs-8');
        }
        
    });
    
    //mobile menu
    var trigger = $('.hamburger'),
           overlay = $('.overlay'),
           isClosed = false;
            
          overlay.click(function(){
            hamburger_cross();
            $('.menu-container').toggleClass('toggled');
          });
          trigger.click(function () {
            hamburger_cross();      
          });
      
          function hamburger_cross() {
      
            if (isClosed == true) {          
              overlay.hide();
              trigger.removeClass('is-open');
              trigger.addClass('is-closed');
              isClosed = false;
              trigger.css({'position':'absolute','left':'0px'});
            } else {   
              overlay.show();
              trigger.removeClass('is-closed');
              trigger.addClass('is-open');
              trigger.css({'position':'fixed','left':'80%'});
              isClosed = true;
            }
        }
        
        $('[data-toggle="offcanvas"]').click(function () {
            $('.menu-container').toggleClass('toggled');
        });
        
        
        //Search Feild
        
        
        $('.foce,.free').focus(function(){
            $('.free').css({'opacity': '1', 'visibility':'visible'});
        }).blur(function(){
            $('.free').css({'opacity': '1', 'visibility':'visible'});               
        });
        
        
        
        $('.foce').keyup(function(e){
            if ($('.foce').val() != '') {
                $('.cross').css('display','block');
                $('.basic').css('display','none');
                $('.ws').css('display','block');
                if (e.keyCode == 13) {
                    $('.foce').submit();
                }
                
            }else{
                $('.cross').css('display','none');
                $('.basic').css('display','block');
                $('.ws').css('display','none');
            }
        });
        
        $('.foc').keyup(function(e){
            if ($('.foc').val() != '') {
                $('.basic').css('display','none');
                $('.ws').css('display','block');
                if (e.keyCode == 13) {
                    $('.foce').submit();
                }
            }else{
                $('.basic').css('display','block');
                $('.ws').css('display','none');
            }
        });
        
        $('.cross').click(function(){
            $('.foce').val('');
            $('.cross').css('display','none');
            $('.basic').css('display','block');
            $('.ws').css('display','none');
            
            setTimeout(function() {
                $('.foce').focus();
            }, 100);
        });
        setTimeout(function() {
            $('.foce').focus();
        }, 1000);
        
        $('.back').click(function(){
            $('.free').css({'opacity': '0', 'visibility':'hidden'}); 
        });
        
        $('.foc').focus(function(){
            $('.free').css({'opacity': '1', 'visibility':'visible'});
            setTimeout(function() {
                $('.foce').focus();
            }, 1000);
            
        }).blur(function(){
            $('.free').css({'opacity': '0', 'visibility':'hidden'});               
        });
        
        
        
    /************************Admin Panel************************/
    
    //admin sidebar
    function baseName(str)
    {
       var base = new String(str).substring(str.lastIndexOf('/') + 1); 
        if(base.lastIndexOf(".") != -1)       
            base = base.substring(0, base.lastIndexOf("."));
       return base;
    }
    $('.list-group a').each(function(){
        $(this).removeClass('active');
        var loc = baseName(window.location.href);
        if (loc == '') {
            $('.list-group a[href="index.php"]').addClass('active');
        }
        $('.list-group a[href="' + loc + '.php"]').addClass('active');
    });
    
    $('#selectallboxes').click(function(){
        if (this.checked) {
            $('.checkboxes').each(function(){
                this.checked = true;
            });
        }else{
            $('.checkboxes').each(function(){
                this.checked = false;
            });
        }
    });

    $('.rate i').mouseenter(function(){
        $(this).removeClass('fa-star-o');
        $(this).addClass('fa-star');
        $(this).css({'color':'#e7b120'});
    }).mouseleave(function(){
        if (!$(this).hasClass('act')) {
            $(this).removeClass('fa-star');
            $(this).addClass('fa-star-o');
            $(this).css({'color':'#c5c5c5'});
        }
        
    });
    
    var post_mid_height = $('.post-mid-one').height();
    $('.post-img-one , .post-foot-one').css({'minHeight': post_mid_height + 'px'});
    
    
    $('.tabsi_tog').click(function(){
        $(this).next('.tabsi').stop().slideToggle();
        $(this).children('i').toggleClass("chvrn");
    });
    
    $('.sci_swi').click(function(){
        $(this).next('.store-names').stop().slideToggle();
        $(this).children('i').toggleClass("chvrni");
    });
    
    
    /******************Coupons.php******************/
    
    //Filter Search Blur
    $('.filter input[type="text"]').each(function(){
        $(this).focus(function(){
            $('.input-group').addClass('shadow');
        }).blur(function(){
            $('.input-group').removeClass('shadow');
        });    
    });
    
    
   //Coupons
   //Size greater than 799
    if(pageY > 799){
        $('.main-cont .coupon').each(function(index , value){
            if ((index + 1) % 3 == 0) {
                $(this).after('<div class="clearfix b-coup"></div>');
            }else{
                $(this).after('');
            }
        });
    }else{
        $('.b-coup').remove();
    }
    
    $(window).resize(function(){
        var pageY = $(this).width();
            if(pageY > 799){
                $('.main-cont .coupon').each(function(index , value){
                if ((index + 1) % 3 == 0) {
                    $(this).after('<div class="clearfix b-coup"></div>');
                    $('.b-coup').nextUntil('.coupon').remove('.b-coup');
                }else{
                    $(this).after('');
                }
            });
        }else{
            $('.b-coup').remove();
        }
    });
    
    //Size 499 to 799
    
    if(pageY > 499 && pageY < 800){
        $('.main-cont .coupon').each(function(index , value){
            if ((index + 1) % 2 == 0) {
                $(this).after('<div class="clearfix c-coup"></div>');
            }else{
                $(this).after('');
            }
        });
    }else{
        $('.c-coup').remove();
    }
    
    $(window).resize(function(){
        var pageY = $(this).width();
            if(pageY > 499 && pageY < 800){
                $('.main-cont .coupon').each(function(index , value){
                if ((index + 1) % 2 == 0) {
                    $(this).after('<div class="clearfix c-coup"></div>');
                    $('.c-coup').nextUntil('.coupon').remove('.c-coup');
                }else{
                    $(this).after('');
                }
            });
        }else{
            $('.c-coup').remove();
        }
    });
    
    
    //Pan pan_body
    
    $('.pan').click(function(){
        $(this).next('.pan_body').slideToggle();
        $(this).children().children('i.fa-chevron-down').toggleClass('chvrn');
    });
    
    $('.pan_body input[type="text"]').each(function(){
        $(this).focus(function(){
            $('.input-group').addClass('shadoww');
        }).blur(function(){
            $('.input-group').removeClass('shadoww');
        });    
    });
    
    $('.act_sm_sidebar').click(function(){
        $('.small-screen-sidebar').css({'visibility':'visible','left': 0 + 'px'});
        $('.small-screen-sidebar .small_side_top').css({'left': 0 + 'px'});
        $('.small-screen-sidebar .small_clepp').css({'left': 0 + 'px'});
    });
    
    $('.small_side_cancel').click(function(){
        $('.small-screen-sidebar').css({'visibility':'visible','left': 100 + '%'});
        $('.small-screen-sidebar .small_side_top').css({'left': 100 + '%'});
        $('.small-screen-sidebar .small_clepp').css({'left': 100 + '%'});
    });
    
    
    /*$('.st_fav a').click(function(){
        $(this).children('i').toggleClass('heart');
        if ($(this).children('i').hasClass('heart')) {
            $(this).children('span').text('Faved!');
        }else{
            $(this).children('span').text('Add Favorite!');
        }
        
    });*/
    
    
    //Responsive All Options
    //departments
    // > 767
    if(pageY > 767){
        $('.department_cats .cat_boxes > div.cat').each(function(index , value){
            if ((index + 1) % 6 == 0) {
                $(this).after('<div class="clearfix a-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
        $('.department_cats .store_boxes > div.cat').each(function(index , value){
            if ((index + 1) % 6 == 0) {
                $(this).after('<div class="clearfix a-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
        //blog_cat _posts
        $('.blog_cat_posts .bcp').each(function(index , value){
            if ((index + 1) % 4 == 0) {
                $(this).after('<div class="clearfix a-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
    }else{
        $('.a-dep').remove();
    }
    
    $(window).resize(function(){
        var pageY = $(this).width();
        if(pageY > 767){
            $('.department_cats .cat_boxes > div.cat').each(function(index , value){
                if ((index + 1) % 6 == 0) {
                    $(this).after('<div class="clearfix a-dep"></div>');
                    $('.a-dep').nextUntil('.cat').remove('.a-dep');
                }else{
                    $(this).after('');
                }
            });
            
            $('.department_cats .store_boxes > div.cat').each(function(index , value){
                if ((index + 1) % 6 == 0) {
                    $(this).after('<div class="clearfix a-dep"></div>');
                    $('.a-dep').nextUntil('.cat').remove('.a-dep');
                }else{
                    $(this).after('');
                }
            });
            
            //blog_cat _posts
            
            $('.blog_cat_posts .bcp').each(function(index , value){
                if ((index + 1) % 4 == 0) {
                    $(this).after('<div class="clearfix a-dep"></div>');
                    $('.a-dep').nextUntil('.bcp').remove('.a-dep');
                }else{
                    $(this).after('');
                }
            });
            
        }else{
            $('.a-dep').remove();
        }
    });
    
    //<=767
    
    if(pageY > 560 && pageY <= 767){
        $('.department_cats .cat_boxes > div.cat').each(function(index , value){
            if ((index + 1) % 4 == 0) {
                $(this).after('<div class="clearfix b-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
        $('.department_cats .store_boxes > div.cat').each(function(index , value){
            if ((index + 1) % 4 == 0) {
                $(this).after('<div class="clearfix b-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
        //blog_cat _posts
        $('.blog_cat_posts .bcp').each(function(index , value){
            if ((index + 1) % 3 == 0) {
                $(this).after('<div class="clearfix b-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
    }else{
        $('.b-dep').remove();
    }
    
    $(window).resize(function(){
        var pageY = $(this).width();
        if(pageY > 560 && pageY <= 767){
            $('.department_cats .cat_boxes > div.cat').each(function(index , value){
                if ((index + 1) % 4 == 0) {
                    $(this).after('<div class="clearfix b-dep"></div>');
                    $('.b-dep').nextUntil('.cat').remove('.b-dep');
                }else{
                    $(this).after('');
                }
            });
            
            $('.department_cats .store_boxes > div.cat').each(function(index , value){
                if ((index + 1) % 4 == 0) {
                    $(this).after('<div class="clearfix b-dep"></div>');
                    $('.b-dep').nextUntil('.cat').remove('.b-dep');
                }else{
                    $(this).after('');
                }
            });
            
            
            //blog_cat _posts
            
            $('.blog_cat_posts .bcp').each(function(index , value){
                if ((index + 1) % 3 == 0) {
                    $(this).after('<div class="clearfix b-dep"></div>');
                    $('.b-dep').nextUntil('.bcp').remove('.b-dep');
                }else{
                    $(this).after('');
                }
            });
            
            
        }else{
            $('.b-dep').remove();
        }
    });
    
    
    
    
    //<=560 && > 430
    /**/if(pageY > 430 && pageY <= 560){
        $('.department_cats .cat_boxes > div.cat').each(function(index , value){
            if ((index + 1) % 3 == 0) {
                $(this).after('<div class="clearfix c-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
        $('.department_cats .store_boxes > div.cat').each(function(index , value){
            if ((index + 1) % 3 == 0) {
                $(this).after('<div class="clearfix c-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
        //blog_cat _posts
        $('.blog_cat_posts .bcp').each(function(index , value){
            if ((index + 1) % 2 == 0) {
                $(this).after('<div class="clearfix c-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
    }else{
        $('.c-dep').remove();
    }
    
    $(window).resize(function(){
        var pageY = $(this).width();
        if(pageY > 430 && pageY <= 560){
            $('.department_cats .cat_boxes > div.cat').each(function(index , value){
                if ((index + 1) % 3 == 0) {
                    $(this).after('<div class="clearfix c-dep"></div>');
                    $('.c-dep').nextUntil('.cat').remove('.c-dep');
                }else{
                    $(this).after('');
                }
            });
            
            $('.department_cats .store_boxes > div.cat').each(function(index , value){
                if ((index + 1) % 3 == 0) {
                    $(this).after('<div class="clearfix c-dep"></div>');
                    $('.c-dep').nextUntil('.cat').remove('.c-dep');
                }else{
                    $(this).after('');
                }
            });
            
            
            //blog_cat _posts
            
            $('.blog_cat_posts .bcp').each(function(index , value){
                if ((index + 1) % 2 == 0) {
                    $(this).after('<div class="clearfix c-dep"></div>');
                    $('.c-dep').nextUntil('.bcp').remove('.c-dep');
                }else{
                    $(this).after('');
                }
            });
            
        }else{
            $('.c-dep').remove();
        }
    });
    
    
    
    //<=430 && > 299
    /**/if(pageY > 299 && pageY <= 430){
        $('.department_cats .cat_boxes > div.cat').each(function(index , value){
            if ((index + 1) % 2 == 0) {
                $(this).after('<div class="clearfix d-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
        $('.department_cats .store_boxes > div.cat').each(function(index , value){
            if ((index + 1) % 2 == 0) {
                $(this).after('<div class="clearfix d-dep"></div>');
            }else{
                $(this).after('');
            }
        });
        
    }else{
        $('.d-dep').remove();
    }
    
    $(window).resize(function(){
        var pageY = $(this).width();
        if(pageY > 299 && pageY <= 430){
            
            $('.department_cats .cat_boxes > div.cat').each(function(index , value){
                if ((index + 1) % 2 == 0) {
                    $(this).after('<div class="clearfix d-dep"></div>');
                    $('.d-dep').nextUntil('.cat').remove('.d-dep');
                }else{
                    $(this).after('');
                }
            });
            
            $('.department_cats .store_boxes > div.cat').each(function(index , value){
                if ((index + 1) % 2 == 0) {
                    $(this).after('<div class="clearfix d-dep"></div>');
                    $('.d-dep').nextUntil('.cat').remove('.d-dep');
                }else{
                    $(this).after('');
                }
            });
            
        }else{
            $('.d-dep').remove();
        }
    });
    
    
    
    //Blog Page Responsive Options
    if(pageY > 480 && pageY <= 767){
        $('.blog_view_posts .post_thumb').each(function(index , value){
            if ((index + 1) % 2 == 0) {
                $(this).after('<div class="clearfix d-dep"></div>');
            }else{
                $(this).after('');
            }
        });
    }
    
    $(window).resize(function(){
        var pageY = $(this).width();
        if(pageY > 480 && pageY <= 767){
            $('.blog_view_posts .post_thumb').each(function(index , value){
                if ((index + 1) % 2 == 0) {
                    $(this).after('<div class="clearfix d-dep"></div>');
                    $('.d-dep').nextUntil('.cat').remove('.d-dep');
                }else{
                    $(this).after('');
                }
            });
        }
    });
    
    
    //FOR BOOTSTRAPE MODEL COPY TEXT
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
    
    
    
    
    
    //Responsive function
    
    function respon(pare,elem,min,max,vals,clas,unt){
        var pageY = $(this).width(); 
        
        if(pageY > min && pageY < max){
            $(elem).each(function(index , value){
                if ((index + 1) % vals == 0) {
                    $(this).after('<div class="clearfix ' + clas + '"></div>');
                }else{
                    $(this).after('');
                }
            });
        }
        
        $(window).resize(function(){
            var pageY = $(this).width();
            var clases = '.' + clas;
            if(pageY > min && pageY < max){
                $(elem).each(function(index , value){
                    if ((index + 1) % vals == 0) {
                        $(this).after('<div class="clearfix ' + clas + '"></div>');
                        $(clases).nextUntil(unt).remove(clases);
                    }else{
                        $(this).after('');
                    }
                });
            }else{
                $(clases).remove(clases);
            }
        });
    }
    
    respon('.featured_thumb','.featured_thumb .b',460,992,3,'brock','.b');
    respon('.featured_thumb','.featured_thumb .b',299,461,2,'brockee','.b');
    $('.nav-tabs').each(function(){
        $(this).children('li').first().addClass('active');    
    });
    $('.tab-content').each(function(){
        $(this).children('.tab-pane').first().addClass('active');    
    });
    
    
    
    //Ajax
    
    //Comment Data
    $(".com-sub").click(function(){
        var com_post_id = $(this).parent().children('.com_post_id').val();
        var firstname = $(this).parent().children().children('.firstname').val();
        var add_comment = $(this).parent().children().children('.add_comment').val();
        if (firstname == '') {
            $(this).parent().children().children('.firstname').next().text('Please enter your first name');
        }else{
            $(this).parent().children().children('.firstname').next().text('');
        }
        
        if (add_comment == '') {
            $(this).parent().children().children('.add_comment').next().text('Please fill out comment box');
        }else{
            $(this).parent().children().children('.add_comment').next().text('');
        }
        
        if (add_comment != '' && firstname != '') {
            var pathname = $(this).parent().children('.com_post_id').attr('id'); // Returns path only
            pathname = pathname + '/comment.php';
            
            $.ajax({
                method: 'POST',
                url: pathname,
                data: {action: 'comment',com_post_id: com_post_id, firstname:firstname, add_comment:add_comment},
                success: function(result){
                    $('.msg').html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Your Comment is successfully posted and waiting for an approval');
                    $('.msg').addClass('alert alert-success alert-dismissible');
                }
            });
            $(this).parent().children().children('.firstname').val('');
            $(this).parent().children().children('.add_comment').val('');
        }
        
    });
    
    $('.post-one-details, .single_coupon').each(function(){
        var com_len = $(this).find('.comm').length;
        $(this).find('.comm:eq(4)').nextAll('.comm').hide();
        $(this).find('#hide_comm').hide();
        if (com_len > 5) {
            $(this).find('#show_comm').show();
        }else{
            $(this).find('#show_comm').hide();
        }
        $(this).find('#show_comm').click(function(){
            $(this).hide();
            $(this).parent().children('.client-comments').find('.comm:eq(4)').nextAll('.comm').show();
            $(this).parent().find('#hide_comm').show();
            $(this).parent().children('.client-comments').css({'height':'500px','overflow-y':'scroll'});
        });
        $(this).find('#hide_comm').click(function(){
            $(this).hide();
            $(this).parent().children('.client-comments').find('.comm:eq(4)').nextAll('.comm').hide();
            $(this).parent().find('#show_comm').show();
            $(this).parent().children('.client-comments').css({'height':'auto','overflow-y':'hidden'});
        });
        
    });
    
    
    
    
    $('.ct').each(function(){
        
        $(this).children('span').click(function(){
            var ct_len_input = $('.ct').find('input[type="checkbox"]:checked').length;
            ct_len_input = (ct_len_input / 2);
            if (ct_len_input < 1) {
                $('.fil_app > u').text('No ');
            }else{
                $('.fil_app > u').text(ct_len_input);
            }
        });
        
        var ct_len_span = $(this).find('span').length;
        if (ct_len_span > 5) {
            if ($(this).hasClass('cta')) {
                $(this).css({'height': '200px','overflow-y': 'scroll'});
            }
            $(this).find('span:eq(4)').nextAll('span').hide();
            $(this).find('br:eq(4)').nextAll('br.smethng').hide();
            $(this).next('.show_all').show();
        }else{
            $(this).css({'height': 'auto','overflow-y': 'hidden'});
        }
        $('.show_all').click(function(){
            $(this).prev('.ct').find('span:eq(4)').nextAll('span').show();
            $(this).prev('.ct').find('br:eq(4)').nextAll('br.smethng').show();
            $(this).hide();
            $(this).next('.show_less').show();
        });
        
        $('.show_less').click(function(){
            $(this).prev('.show_all').prev('.ct').find('span:eq(4)').nextAll('span').hide();
            $(this).prev('.show_all').prev('.ct').find('br:eq(4)').nextAll('br.smethng').hide();
            $(this).hide();
            $(this).prev('.show_all').show();
        });
    });
    
    
    
    //Depaements Load More
    function load_more(elem,end,inc,btn,btn_two){
        $(elem).css({'display' : 'none'});
        $(btn_two).css({'display' : 'none'});
        
        for(var start = 0; start < end; start++){
            var elems = elem + ':eq('+ start +')';
            $(elems).css({'display' : 'inline-block'});
            
            if (start >= $(elem).length) {
                $(btn).css({'display' : 'none'});
                $(btn_two).css({'display' : 'block'});
            }
        }
        
        $(btn).click(function(){
            end = end + inc;
            for(var start = 0; start < end; start++){
                var elems = elem + ':eq('+ start +')';
                $(elems).css({'display' : 'inline-block'});
                
                if (start >= $(elem).length) {
                    $(btn).css({'display' : 'none'});
                    $(btn_two).css({'display' : 'block'});
                }
            }
        });
        
        $(btn_two).click(function(){
            end = inc;
            $(elem).css({'display' : 'none'});
            for(var start = 0; start < end; start++){
                var elems = elem + ':eq('+ start +')';
                $(elems).css({'display' : 'inline-block'});
                $(btn).css({'display' : 'block'});
                $(btn_two).css({'display' : 'none'});
            }
        });
    }
    load_more('.department_cats .cat_boxes > div.cat',12,12,'.load_more_dep','.show_less_dep');
});