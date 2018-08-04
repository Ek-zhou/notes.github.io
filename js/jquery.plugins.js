/*
 * jQuery SelectBox Styler v1.0.1
 * http://dimox.name/styling-select-boxes-using-jquery-css/
 *
 * Copyright 2012 Dimox (http://dimox.name/)
 * Released under the MIT license.
 *
 * Date: 2012.10.07
 *
 */

(function($) {
    $.fn.selectbox = function(options) {
        var settings = $.extend({ styleClass: '' }, options);
        var rtl = $('body').hasClass('rtl') ? true : false;
        $(this).each(function() {
            var styleClass = settings.styleClass;
            var select = $(this);
            if (select.prev('span.selectbox').length < 1) {
                function doSelect() {
                    var option = select.find('option');
                    var optionSelected = option.filter(':selected');
                    var optionText = option.filter(':first').text();
                    if(option.filter(':first').attr('data-image'))
                        optionText = '<img src="' + option.filter(':first').attr('data-image') + '"/>' + optionText;
                    
                    if (optionSelected.length){
                        optionText = optionSelected.text();
                        if(optionSelected.attr('data-image'))
                            optionText = '<img src="' + optionSelected.attr('data-image') + '"/>' + optionText;

                    }
                    
                    var ddlist = '';
                    for (i = 0; i < option.length; i++) {
                        var selected = '';
                        var disabled = ' class="disabled"';
                        if (option.eq(i).is(':selected')) {
                            selected = ' class="selected sel"';
                            ddlist += '<li' + selected + '><a>'
                            if(option.eq(i).attr('data-image'))
                                ddlist += '<img src="' + option.eq(i).attr('data-image') + '"/>';
                            ddlist += option.eq(i).text() +'</a></li>';
                        }
                        else
                        if (option.eq(i).is(':disabled')) {
                            selected = disabled;
                            ddlist += '<li' + selected + '><a>'+ option.eq(i).text() +'</a></li>';
                        }
                        else {
                            ddlist += '<li' + selected + '><a href="'+option.eq(i).val()+'">';
                            if(option.eq(i).attr('data-image'))
                                ddlist += '<img src="' + option.eq(i).attr('data-image') + '"/>';
                            ddlist += option.eq(i).html() +'</a></li>';
                        }
                        //ddlist += '<li' + selected + '>'+ option.eq(i).text() +'</li>';
                        //ddlist += '<li' + selected + '><a href="'+option.eq(i).val()+'">'+ option.eq(i).html() +'</a></li>';
                    }
                    if (!rtl) {
                        var selectbox =
                            $('<span class="selectbox '+styleClass+'" style="display:inline-block;position:relative">'+
                                '<div class="select" style="float:left;position:relative;z-index:10000"><div class="text">' + optionText + '</div>'+
                                '<b class="trigger"><i class="icon-down-dir"></i></b>'+
                                '</div>'+
                                '<div class="dropdown" style="position:absolute;z-index:9999;overflow:auto;overflow-x:hidden;list-style:none">'+
                                '<ul>' + ddlist + '</ul>'+
                                '</div>'+
                                '</span>');
                    } else {
                        var selectbox =
                            $('<span class="selectbox '+styleClass+'" style="display:inline-block;position:relative">'+
                                '<div class="select" style="float:right;position:relative;z-index:10000"><div class="text">' + optionText + '</div>'+
                                '<b class="trigger"><i class="icon-down-dir"></i></b>'+
                                '</div>'+
                                '<div class="dropdown" style="position:absolute;z-index:9999;overflow:auto;overflow-x:hidden;list-style:none">'+
                                '<ul>' + ddlist + '</ul>'+
                                '</div>'+
                                '</span>');
                    }
                    select.before(selectbox).css({position: 'absolute', top: -9999});
                    var divSelect = selectbox.find('div.select');
                    var divText = selectbox.find('div.text');
                    var dropdown = selectbox.find('div.dropdown');
                    var li = dropdown.find('li');
                    var selectHeight = selectbox.outerHeight();
                    if (!rtl) {
                        if (dropdown.css('left') == 'auto') dropdown.css({left: 0});
                    } else {
                        if (dropdown.css('right') == 'auto') dropdown.css({right: 0});
                    }
                    if (dropdown.css('top') == 'auto' || dropdown.css('top') == '0px'){ dropdown.css({top: selectHeight}); }
                    var liHeight = li.outerHeight();
                    var position = dropdown.css('top');
                    dropdown.hide();
                    dropdown.css('width', dropdown.parent().width()+"px");
                    /* при клике на псевдоселекте */
                    divSelect.mouseover(function() {
                        /* умное позиционирование */
                        var topOffset = selectbox.offset().top;
                        var bottomOffset = $(window).height() - selectHeight - (topOffset - $(window).scrollTop());
                        if (bottomOffset < 0 || bottomOffset < liHeight * 6)    {
                            dropdown.height('auto').css({top: 'auto', bottom: position});
                            dropdown.addClass('top-dropdown');
                            if (dropdown.outerHeight() > topOffset - $(window).scrollTop() - 20 ) {
                                dropdown.height(Math.floor((topOffset - $(window).scrollTop() - 20) / liHeight) * liHeight);
                            }
                        } else if (bottomOffset > liHeight * 6) {
                            dropdown.height('auto').css({bottom: 'auto', top: position});
                            if (dropdown.outerHeight() > bottomOffset - 20 ) {
                                dropdown.height(Math.floor((bottomOffset - 20) / liHeight) * liHeight);
                            }
                        }
                        dropdown.css('width', dropdown.parent().width()+"px");

                        $('span.selectbox').css({zIndex: 1}).removeClass('focused');
                        selectbox.css({zIndex: 4});
                        if (dropdown.is(':hidden')) {
                            $('div.dropdown:visible').hide();
                            dropdown.fadeIn('fast');
                        } 
                        return false;
                    });
                    $('span.selectbox').mouseleave(function(){
                        dropdown.fadeOut('fast');
                        dropdown.removeClass('top-dropdown');
                        return false;
                    });
                    /* при наведении курсора на пункт списка */
                    li.hover(function() {
                        $(this).siblings().removeClass('selected');
                    });
                    var selectedText = li.filter('.selected').text();
                    /* при клике на пункт списка */
                    li.filter(':not(.disabled)').click(function() {
                        var liText = $(this).text();
                        if ( selectedText != liText ) {
                            $(this).addClass('selected sel').siblings().removeClass('selected sel');
                            option.removeAttr('selected').eq($(this).index()).attr('selected', true);
                            selectedText = liText;
                            divText.text(liText);
                            select.change();
                        }
                        dropdown.hide();
                    });
                    dropdown.mouseout(function() {
                        dropdown.find('li.sel').addClass('selected');
                    });
                    /* фокус на селекте */
                    select.focus(function() {
                        $('span.selectbox').removeClass('focused');
                        selectbox.addClass('focused');
                    })
                    /* меняем селект с клавиатуры */
                    .keyup(function() {
                        divText.text(option.filter(':selected').text());
                        li.removeClass('selected sel').eq(option.filter(':selected').index()).addClass('selected sel');
                    });
                    /* прячем выпадающий список при клике за пределами селекта */
                    $(document).on('click', function(e) {
                        if (!$(e.target).parents().hasClass('selectbox')) {
                            dropdown.hide().find('li.sel').addClass('selected');
                            selectbox.removeClass('focused');
                        }
                    });
                }
                doSelect();
                // обновление при динамическом изменении
                select.on('refresh', function() {
                    select.prev().remove();
                    doSelect();
                })
            }
        });
    }
})(jQuery);

/*! skrollr 0.6.30 (2015-08-12) | Alexander Prinzhorn - https://github.com/Prinzhorn/skrollr | Free to use under terms of MIT license */
!function(a,b,c){"use strict";function d(c){if(e=b.documentElement,f=b.body,T(),ha=this,c=c||{},ma=c.constants||{},c.easing)for(var d in c.easing)W[d]=c.easing[d];ta=c.edgeStrategy||"set",ka={beforerender:c.beforerender,render:c.render,keyframe:c.keyframe},la=c.forceHeight!==!1,la&&(Ka=c.scale||1),na=c.mobileDeceleration||y,pa=c.smoothScrolling!==!1,qa=c.smoothScrollingDuration||A,ra={targetTop:ha.getScrollTop()},Sa=(c.mobileCheck||function(){return/Android|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent||navigator.vendor||a.opera)})(),Sa?(ja=b.getElementById(c.skrollrBody||z),ja&&ga(),X(),Ea(e,[s,v],[t])):Ea(e,[s,u],[t]),ha.refresh(),wa(a,"resize orientationchange",function(){var a=e.clientWidth,b=e.clientHeight;(b!==Pa||a!==Oa)&&(Pa=b,Oa=a,Qa=!0)});var g=U();return function h(){$(),va=g(h)}(),ha}var e,f,g={get:function(){return ha},init:function(a){return ha||new d(a)},VERSION:"0.6.30"},h=Object.prototype.hasOwnProperty,i=a.Math,j=a.getComputedStyle,k="touchstart",l="touchmove",m="touchcancel",n="touchend",o="skrollable",p=o+"-before",q=o+"-between",r=o+"-after",s="skrollr",t="no-"+s,u=s+"-desktop",v=s+"-mobile",w="linear",x=1e3,y=.004,z="skrollr-body",A=200,B="start",C="end",D="center",E="bottom",F="___skrollable_id",G=/^(?:input|textarea|button|select)$/i,H=/^\s+|\s+$/g,I=/^data(?:-(_\w+))?(?:-?(-?\d*\.?\d+p?))?(?:-?(start|end|top|center|bottom))?(?:-?(top|center|bottom))?$/,J=/\s*(@?[\w\-\[\]]+)\s*:\s*(.+?)\s*(?:;|$)/gi,K=/^(@?[a-z\-]+)\[(\w+)\]$/,L=/-([a-z0-9_])/g,M=function(a,b){return b.toUpperCase()},N=/[\-+]?[\d]*\.?[\d]+/g,O=/\{\?\}/g,P=/rgba?\(\s*-?\d+\s*,\s*-?\d+\s*,\s*-?\d+/g,Q=/[a-z\-]+-gradient/g,R="",S="",T=function(){var a=/^(?:O|Moz|webkit|ms)|(?:-(?:o|moz|webkit|ms)-)/;if(j){var b=j(f,null);for(var c in b)if(R=c.match(a)||+c==c&&b[c].match(a))break;if(!R)return void(R=S="");R=R[0],"-"===R.slice(0,1)?(S=R,R={"-webkit-":"webkit","-moz-":"Moz","-ms-":"ms","-o-":"O"}[R]):S="-"+R.toLowerCase()+"-"}},U=function(){var b=a.requestAnimationFrame||a[R.toLowerCase()+"RequestAnimationFrame"],c=Ha();return(Sa||!b)&&(b=function(b){var d=Ha()-c,e=i.max(0,1e3/60-d);return a.setTimeout(function(){c=Ha(),b()},e)}),b},V=function(){var b=a.cancelAnimationFrame||a[R.toLowerCase()+"CancelAnimationFrame"];return(Sa||!b)&&(b=function(b){return a.clearTimeout(b)}),b},W={begin:function(){return 0},end:function(){return 1},linear:function(a){return a},quadratic:function(a){return a*a},cubic:function(a){return a*a*a},swing:function(a){return-i.cos(a*i.PI)/2+.5},sqrt:function(a){return i.sqrt(a)},outCubic:function(a){return i.pow(a-1,3)+1},bounce:function(a){var b;if(.5083>=a)b=3;else if(.8489>=a)b=9;else if(.96208>=a)b=27;else{if(!(.99981>=a))return 1;b=91}return 1-i.abs(3*i.cos(a*b*1.028)/b)}};d.prototype.refresh=function(a){var d,e,f=!1;for(a===c?(f=!0,ia=[],Ra=0,a=b.getElementsByTagName("*")):a.length===c&&(a=[a]),d=0,e=a.length;e>d;d++){var g=a[d],h=g,i=[],j=pa,k=ta,l=!1;if(f&&F in g&&delete g[F],g.attributes){for(var m=0,n=g.attributes.length;n>m;m++){var p=g.attributes[m];if("data-anchor-target"!==p.name)if("data-smooth-scrolling"!==p.name)if("data-edge-strategy"!==p.name)if("data-emit-events"!==p.name){var q=p.name.match(I);if(null!==q){var r={props:p.value,element:g,eventType:p.name.replace(L,M)};i.push(r);var s=q[1];s&&(r.constant=s.substr(1));var t=q[2];/p$/.test(t)?(r.isPercentage=!0,r.offset=(0|t.slice(0,-1))/100):r.offset=0|t;var u=q[3],v=q[4]||u;u&&u!==B&&u!==C?(r.mode="relative",r.anchors=[u,v]):(r.mode="absolute",u===C?r.isEnd=!0:r.isPercentage||(r.offset=r.offset*Ka))}}else l=!0;else k=p.value;else j="off"!==p.value;else if(h=b.querySelector(p.value),null===h)throw'Unable to find anchor target "'+p.value+'"'}if(i.length){var w,x,y;!f&&F in g?(y=g[F],w=ia[y].styleAttr,x=ia[y].classAttr):(y=g[F]=Ra++,w=g.style.cssText,x=Da(g)),ia[y]={element:g,styleAttr:w,classAttr:x,anchorTarget:h,keyFrames:i,smoothScrolling:j,edgeStrategy:k,emitEvents:l,lastFrameIndex:-1},Ea(g,[o],[])}}}for(Aa(),d=0,e=a.length;e>d;d++){var z=ia[a[d][F]];z!==c&&(_(z),ba(z))}return ha},d.prototype.relativeToAbsolute=function(a,b,c){var d=e.clientHeight,f=a.getBoundingClientRect(),g=f.top,h=f.bottom-f.top;return b===E?g-=d:b===D&&(g-=d/2),c===E?g+=h:c===D&&(g+=h/2),g+=ha.getScrollTop(),g+.5|0},d.prototype.animateTo=function(a,b){b=b||{};var d=Ha(),e=ha.getScrollTop(),f=b.duration===c?x:b.duration;return oa={startTop:e,topDiff:a-e,targetTop:a,duration:f,startTime:d,endTime:d+f,easing:W[b.easing||w],done:b.done},oa.topDiff||(oa.done&&oa.done.call(ha,!1),oa=c),ha},d.prototype.stopAnimateTo=function(){oa&&oa.done&&oa.done.call(ha,!0),oa=c},d.prototype.isAnimatingTo=function(){return!!oa},d.prototype.isMobile=function(){return Sa},d.prototype.setScrollTop=function(b,c){return sa=c===!0,Sa?Ta=i.min(i.max(b,0),Ja):a.scrollTo(0,b),ha},d.prototype.getScrollTop=function(){return Sa?Ta:a.pageYOffset||e.scrollTop||f.scrollTop||0},d.prototype.getMaxScrollTop=function(){return Ja},d.prototype.on=function(a,b){return ka[a]=b,ha},d.prototype.off=function(a){return delete ka[a],ha},d.prototype.destroy=function(){var a=V();a(va),ya(),Ea(e,[t],[s,u,v]);for(var b=0,d=ia.length;d>b;b++)fa(ia[b].element);e.style.overflow=f.style.overflow="",e.style.height=f.style.height="",ja&&g.setStyle(ja,"transform","none"),ha=c,ja=c,ka=c,la=c,Ja=0,Ka=1,ma=c,na=c,La="down",Ma=-1,Oa=0,Pa=0,Qa=!1,oa=c,pa=c,qa=c,ra=c,sa=c,Ra=0,ta=c,Sa=!1,Ta=0,ua=c};var X=function(){var d,g,h,j,o,p,q,r,s,t,u,v;wa(e,[k,l,m,n].join(" "),function(a){var e=a.changedTouches[0];for(j=a.target;3===j.nodeType;)j=j.parentNode;switch(o=e.clientY,p=e.clientX,t=a.timeStamp,G.test(j.tagName)||a.preventDefault(),a.type){case k:d&&d.blur(),ha.stopAnimateTo(),d=j,g=q=o,h=p,s=t;break;case l:G.test(j.tagName)&&b.activeElement!==j&&a.preventDefault(),r=o-q,v=t-u,ha.setScrollTop(Ta-r,!0),q=o,u=t;break;default:case m:case n:var f=g-o,w=h-p,x=w*w+f*f;if(49>x){if(!G.test(d.tagName)){d.focus();var y=b.createEvent("MouseEvents");y.initMouseEvent("click",!0,!0,a.view,1,e.screenX,e.screenY,e.clientX,e.clientY,a.ctrlKey,a.altKey,a.shiftKey,a.metaKey,0,null),d.dispatchEvent(y)}return}d=c;var z=r/v;z=i.max(i.min(z,3),-3);var A=i.abs(z/na),B=z*A+.5*na*A*A,C=ha.getScrollTop()-B,D=0;C>Ja?(D=(Ja-C)/B,C=Ja):0>C&&(D=-C/B,C=0),A*=1-D,ha.animateTo(C+.5|0,{easing:"outCubic",duration:A})}}),a.scrollTo(0,0),e.style.overflow=f.style.overflow="hidden"},Y=function(){var a,b,c,d,f,g,h,j,k,l,m,n=e.clientHeight,o=Ba();for(j=0,k=ia.length;k>j;j++)for(a=ia[j],b=a.element,c=a.anchorTarget,d=a.keyFrames,f=0,g=d.length;g>f;f++)h=d[f],l=h.offset,m=o[h.constant]||0,h.frame=l,h.isPercentage&&(l*=n,h.frame=l),"relative"===h.mode&&(fa(b),h.frame=ha.relativeToAbsolute(c,h.anchors[0],h.anchors[1])-l,fa(b,!0)),h.frame+=m,la&&!h.isEnd&&h.frame>Ja&&(Ja=h.frame);for(Ja=i.max(Ja,Ca()),j=0,k=ia.length;k>j;j++){for(a=ia[j],d=a.keyFrames,f=0,g=d.length;g>f;f++)h=d[f],m=o[h.constant]||0,h.isEnd&&(h.frame=Ja-h.offset+m);a.keyFrames.sort(Ia)}},Z=function(a,b){for(var c=0,d=ia.length;d>c;c++){var e,f,i=ia[c],j=i.element,k=i.smoothScrolling?a:b,l=i.keyFrames,m=l.length,n=l[0],s=l[l.length-1],t=k<n.frame,u=k>s.frame,v=t?n:s,w=i.emitEvents,x=i.lastFrameIndex;if(t||u){if(t&&-1===i.edge||u&&1===i.edge)continue;switch(t?(Ea(j,[p],[r,q]),w&&x>-1&&(za(j,n.eventType,La),i.lastFrameIndex=-1)):(Ea(j,[r],[p,q]),w&&m>x&&(za(j,s.eventType,La),i.lastFrameIndex=m)),i.edge=t?-1:1,i.edgeStrategy){case"reset":fa(j);continue;case"ease":k=v.frame;break;default:case"set":var y=v.props;for(e in y)h.call(y,e)&&(f=ea(y[e].value),0===e.indexOf("@")?j.setAttribute(e.substr(1),f):g.setStyle(j,e,f));continue}}else 0!==i.edge&&(Ea(j,[o,q],[p,r]),i.edge=0);for(var z=0;m-1>z;z++)if(k>=l[z].frame&&k<=l[z+1].frame){var A=l[z],B=l[z+1];for(e in A.props)if(h.call(A.props,e)){var C=(k-A.frame)/(B.frame-A.frame);C=A.props[e].easing(C),f=da(A.props[e].value,B.props[e].value,C),f=ea(f),0===e.indexOf("@")?j.setAttribute(e.substr(1),f):g.setStyle(j,e,f)}w&&x!==z&&("down"===La?za(j,A.eventType,La):za(j,B.eventType,La),i.lastFrameIndex=z);break}}},$=function(){Qa&&(Qa=!1,Aa());var a,b,d=ha.getScrollTop(),e=Ha();if(oa)e>=oa.endTime?(d=oa.targetTop,a=oa.done,oa=c):(b=oa.easing((e-oa.startTime)/oa.duration),d=oa.startTop+b*oa.topDiff|0),ha.setScrollTop(d,!0);else if(!sa){var f=ra.targetTop-d;f&&(ra={startTop:Ma,topDiff:d-Ma,targetTop:d,startTime:Na,endTime:Na+qa}),e<=ra.endTime&&(b=W.sqrt((e-ra.startTime)/qa),d=ra.startTop+b*ra.topDiff|0)}if(sa||Ma!==d){La=d>Ma?"down":Ma>d?"up":La,sa=!1;var h={curTop:d,lastTop:Ma,maxTop:Ja,direction:La},i=ka.beforerender&&ka.beforerender.call(ha,h);i!==!1&&(Z(d,ha.getScrollTop()),Sa&&ja&&g.setStyle(ja,"transform","translate(0, "+-Ta+"px) "+ua),Ma=d,ka.render&&ka.render.call(ha,h)),a&&a.call(ha,!1)}Na=e},_=function(a){for(var b=0,c=a.keyFrames.length;c>b;b++){for(var d,e,f,g,h=a.keyFrames[b],i={};null!==(g=J.exec(h.props));)f=g[1],e=g[2],d=f.match(K),null!==d?(f=d[1],d=d[2]):d=w,e=e.indexOf("!")?aa(e):[e.slice(1)],i[f]={value:e,easing:W[d]};h.props=i}},aa=function(a){var b=[];return P.lastIndex=0,a=a.replace(P,function(a){return a.replace(N,function(a){return a/255*100+"%"})}),S&&(Q.lastIndex=0,a=a.replace(Q,function(a){return S+a})),a=a.replace(N,function(a){return b.push(+a),"{?}"}),b.unshift(a),b},ba=function(a){var b,c,d={};for(b=0,c=a.keyFrames.length;c>b;b++)ca(a.keyFrames[b],d);for(d={},b=a.keyFrames.length-1;b>=0;b--)ca(a.keyFrames[b],d)},ca=function(a,b){var c;for(c in b)h.call(a.props,c)||(a.props[c]=b[c]);for(c in a.props)b[c]=a.props[c]},da=function(a,b,c){var d,e=a.length;if(e!==b.length)throw"Can't interpolate between \""+a[0]+'" and "'+b[0]+'"';var f=[a[0]];for(d=1;e>d;d++)f[d]=a[d]+(b[d]-a[d])*c;return f},ea=function(a){var b=1;return O.lastIndex=0,a[0].replace(O,function(){return a[b++]})},fa=function(a,b){a=[].concat(a);for(var c,d,e=0,f=a.length;f>e;e++)d=a[e],c=ia[d[F]],c&&(b?(d.style.cssText=c.dirtyStyleAttr,Ea(d,c.dirtyClassAttr)):(c.dirtyStyleAttr=d.style.cssText,c.dirtyClassAttr=Da(d),d.style.cssText=c.styleAttr,Ea(d,c.classAttr)))},ga=function(){ua="translateZ(0)",g.setStyle(ja,"transform",ua);var a=j(ja),b=a.getPropertyValue("transform"),c=a.getPropertyValue(S+"transform"),d=b&&"none"!==b||c&&"none"!==c;d||(ua="")};g.setStyle=function(a,b,c){var d=a.style;if(b=b.replace(L,M).replace("-",""),"zIndex"===b)isNaN(c)?d[b]=c:d[b]=""+(0|c);else if("float"===b)d.styleFloat=d.cssFloat=c;else try{R&&(d[R+b.slice(0,1).toUpperCase()+b.slice(1)]=c),d[b]=c}catch(e){}};var ha,ia,ja,ka,la,ma,na,oa,pa,qa,ra,sa,ta,ua,va,wa=g.addEvent=function(b,c,d){var e=function(b){return b=b||a.event,b.target||(b.target=b.srcElement),b.preventDefault||(b.preventDefault=function(){b.returnValue=!1,b.defaultPrevented=!0}),d.call(this,b)};c=c.split(" ");for(var f,g=0,h=c.length;h>g;g++)f=c[g],b.addEventListener?b.addEventListener(f,d,!1):b.attachEvent("on"+f,e),Ua.push({element:b,name:f,listener:d})},xa=g.removeEvent=function(a,b,c){b=b.split(" ");for(var d=0,e=b.length;e>d;d++)a.removeEventListener?a.removeEventListener(b[d],c,!1):a.detachEvent("on"+b[d],c)},ya=function(){for(var a,b=0,c=Ua.length;c>b;b++)a=Ua[b],xa(a.element,a.name,a.listener);Ua=[]},za=function(a,b,c){ka.keyframe&&ka.keyframe.call(ha,a,b,c)},Aa=function(){var a=ha.getScrollTop();Ja=0,la&&!Sa&&(f.style.height=""),Y(),la&&!Sa&&(f.style.height=Ja+e.clientHeight+"px"),Sa?ha.setScrollTop(i.min(ha.getScrollTop(),Ja)):ha.setScrollTop(a,!0),sa=!0},Ba=function(){var a,b,c=e.clientHeight,d={};for(a in ma)b=ma[a],"function"==typeof b?b=b.call(ha):/p$/.test(b)&&(b=b.slice(0,-1)/100*c),d[a]=b;return d},Ca=function(){var a,b=0;return ja&&(b=i.max(ja.offsetHeight,ja.scrollHeight)),a=i.max(b,f.scrollHeight,f.offsetHeight,e.scrollHeight,e.offsetHeight,e.clientHeight),a-e.clientHeight},Da=function(b){var c="className";return a.SVGElement&&b instanceof a.SVGElement&&(b=b[c],c="baseVal"),b[c]},Ea=function(b,d,e){var f="className";if(a.SVGElement&&b instanceof a.SVGElement&&(b=b[f],f="baseVal"),e===c)return void(b[f]=d);for(var g=b[f],h=0,i=e.length;i>h;h++)g=Ga(g).replace(Ga(e[h])," ");g=Fa(g);for(var j=0,k=d.length;k>j;j++)-1===Ga(g).indexOf(Ga(d[j]))&&(g+=" "+d[j]);b[f]=Fa(g)},Fa=function(a){return a.replace(H,"")},Ga=function(a){return" "+a+" "},Ha=Date.now||function(){return+new Date},Ia=function(a,b){return a.frame-b.frame},Ja=0,Ka=1,La="down",Ma=-1,Na=Ha(),Oa=0,Pa=0,Qa=!1,Ra=0,Sa=!1,Ta=0,Ua=[];"function"==typeof define&&define.amd?define([],function(){return g}):"undefined"!=typeof module&&module.exports?module.exports=g:a.skrollr=g}(window,document);

// Generated by CoffeeScript 1.6.2
/*!
jQuery Waypoints - v2.0.5
Copyright (c) 2011-2014 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/jquery-waypoints/blob/master/licenses.txt
*/
(function(){var t=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++){if(e in this&&this[e]===t)return e}return-1},e=[].slice;(function(t,e){if(typeof define==="function"&&define.amd){return define("waypoints",["jquery"],function(n){return e(n,t)})}else{return e(t.jQuery,t)}})(window,function(n,r){var i,o,l,s,f,u,c,a,h,d,p,y,v,w,g,m;i=n(r);a=t.call(r,"ontouchstart")>=0;s={horizontal:{},vertical:{}};f=1;c={};u="waypoints-context-id";p="resize.waypoints";y="scroll.waypoints";v=1;w="waypoints-waypoint-ids";g="waypoint";m="waypoints";o=function(){function t(t){var e=this;this.$element=t;this.element=t[0];this.didResize=false;this.didScroll=false;this.id="context"+f++;this.oldScroll={x:t.scrollLeft(),y:t.scrollTop()};this.waypoints={horizontal:{},vertical:{}};this.element[u]=this.id;c[this.id]=this;t.bind(y,function(){var t;if(!(e.didScroll||a)){e.didScroll=true;t=function(){e.doScroll();return e.didScroll=false};return r.setTimeout(t,n[m].settings.scrollThrottle)}});t.bind(p,function(){var t;if(!e.didResize){e.didResize=true;t=function(){n[m]("refresh");return e.didResize=false};return r.setTimeout(t,n[m].settings.resizeThrottle)}})}t.prototype.doScroll=function(){var t,e=this;t={horizontal:{newScroll:this.$element.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.$element.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};if(a&&(!t.vertical.oldScroll||!t.vertical.newScroll)){n[m]("refresh")}n.each(t,function(t,r){var i,o,l;l=[];o=r.newScroll>r.oldScroll;i=o?r.forward:r.backward;n.each(e.waypoints[t],function(t,e){var n,i;if(r.oldScroll<(n=e.offset)&&n<=r.newScroll){return l.push(e)}else if(r.newScroll<(i=e.offset)&&i<=r.oldScroll){return l.push(e)}});l.sort(function(t,e){return t.offset-e.offset});if(!o){l.reverse()}return n.each(l,function(t,e){if(e.options.continuous||t===l.length-1){return e.trigger([i])}})});return this.oldScroll={x:t.horizontal.newScroll,y:t.vertical.newScroll}};t.prototype.refresh=function(){var t,e,r,i=this;r=n.isWindow(this.element);e=this.$element.offset();this.doScroll();t={horizontal:{contextOffset:r?0:e.left,contextScroll:r?0:this.oldScroll.x,contextDimension:this.$element.width(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:r?0:e.top,contextScroll:r?0:this.oldScroll.y,contextDimension:r?n[m]("viewportHeight"):this.$element.height(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};return n.each(t,function(t,e){return n.each(i.waypoints[t],function(t,r){var i,o,l,s,f;i=r.options.offset;l=r.offset;o=n.isWindow(r.element)?0:r.$element.offset()[e.offsetProp];if(n.isFunction(i)){i=i.apply(r.element)}else if(typeof i==="string"){i=parseFloat(i);if(r.options.offset.indexOf("%")>-1){i=Math.ceil(e.contextDimension*i/100)}}r.offset=o-e.contextOffset+e.contextScroll-i;if(r.options.onlyOnScroll&&l!=null||!r.enabled){return}if(l!==null&&l<(s=e.oldScroll)&&s<=r.offset){return r.trigger([e.backward])}else if(l!==null&&l>(f=e.oldScroll)&&f>=r.offset){return r.trigger([e.forward])}else if(l===null&&e.oldScroll>=r.offset){return r.trigger([e.forward])}})})};t.prototype.checkEmpty=function(){if(n.isEmptyObject(this.waypoints.horizontal)&&n.isEmptyObject(this.waypoints.vertical)){this.$element.unbind([p,y].join(" "));return delete c[this.id]}};return t}();l=function(){function t(t,e,r){var i,o;if(r.offset==="bottom-in-view"){r.offset=function(){var t;t=n[m]("viewportHeight");if(!n.isWindow(e.element)){t=e.$element.height()}return t-n(this).outerHeight()}}this.$element=t;this.element=t[0];this.axis=r.horizontal?"horizontal":"vertical";this.callback=r.handler;this.context=e;this.enabled=r.enabled;this.id="waypoints"+v++;this.offset=null;this.options=r;e.waypoints[this.axis][this.id]=this;s[this.axis][this.id]=this;i=(o=this.element[w])!=null?o:[];i.push(this.id);this.element[w]=i}t.prototype.trigger=function(t){if(!this.enabled){return}if(this.callback!=null){this.callback.apply(this.element,t)}if(this.options.triggerOnce){return this.destroy()}};t.prototype.disable=function(){return this.enabled=false};t.prototype.enable=function(){this.context.refresh();return this.enabled=true};t.prototype.destroy=function(){delete s[this.axis][this.id];delete this.context.waypoints[this.axis][this.id];return this.context.checkEmpty()};t.getWaypointsByElement=function(t){var e,r;r=t[w];if(!r){return[]}e=n.extend({},s.horizontal,s.vertical);return n.map(r,function(t){return e[t]})};return t}();d={init:function(t,e){var r;e=n.extend({},n.fn[g].defaults,e);if((r=e.handler)==null){e.handler=t}this.each(function(){var t,r,i,s;t=n(this);i=(s=e.context)!=null?s:n.fn[g].defaults.context;if(!n.isWindow(i)){i=t.closest(i)}i=n(i);r=c[i[0][u]];if(!r){r=new o(i)}return new l(t,r,e)});n[m]("refresh");return this},disable:function(){return d._invoke.call(this,"disable")},enable:function(){return d._invoke.call(this,"enable")},destroy:function(){return d._invoke.call(this,"destroy")},prev:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e>0){return t.push(n[e-1])}})},next:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e<n.length-1){return t.push(n[e+1])}})},_traverse:function(t,e,i){var o,l;if(t==null){t="vertical"}if(e==null){e=r}l=h.aggregate(e);o=[];this.each(function(){var e;e=n.inArray(this,l[t]);return i(o,e,l[t])});return this.pushStack(o)},_invoke:function(t){this.each(function(){var e;e=l.getWaypointsByElement(this);return n.each(e,function(e,n){n[t]();return true})});return this}};n.fn[g]=function(){var t,r;r=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(d[r]){return d[r].apply(this,t)}else if(n.isFunction(r)){return d.init.apply(this,arguments)}else if(n.isPlainObject(r)){return d.init.apply(this,[null,r])}else if(!r){return n.error("jQuery Waypoints needs a callback function or handler option.")}else{return n.error("The "+r+" method does not exist in jQuery Waypoints.")}};n.fn[g].defaults={context:r,continuous:true,enabled:true,horizontal:false,offset:0,triggerOnce:false};h={refresh:function(){return n.each(c,function(t,e){return e.refresh()})},viewportHeight:function(){var t;return(t=r.innerHeight)!=null?t:i.height()},aggregate:function(t){var e,r,i;e=s;if(t){e=(i=c[n(t)[0][u]])!=null?i.waypoints:void 0}if(!e){return[]}r={horizontal:[],vertical:[]};n.each(r,function(t,i){n.each(e[t],function(t,e){return i.push(e)});i.sort(function(t,e){return t.offset-e.offset});r[t]=n.map(i,function(t){return t.element});return r[t]=n.unique(r[t])});return r},above:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset<=t.oldScroll.y})},below:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset>t.oldScroll.y})},left:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset<=t.oldScroll.x})},right:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset>t.oldScroll.x})},enable:function(){return h._invoke("enable")},disable:function(){return h._invoke("disable")},destroy:function(){return h._invoke("destroy")},extendFn:function(t,e){return d[t]=e},_invoke:function(t){var e;e=n.extend({},s.vertical,s.horizontal);return n.each(e,function(e,n){n[t]();return true})},_filter:function(t,e,r){var i,o;i=c[n(t)[0][u]];if(!i){return[]}o=[];n.each(i.waypoints[e],function(t,e){if(r(i,e)){return o.push(e)}});o.sort(function(t,e){return t.offset-e.offset});return n.map(o,function(t){return t.element})}};n[m]=function(){var t,n;n=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(h[n]){return h[n].apply(null,t)}else{return h.aggregate.call(null,n)}};n[m].settings={resizeThrottle:100,scrollThrottle:30};return i.on("load.waypoints",function(){return n[m]("refresh")})})}).call(this);

/* Modernizr 2.8.3 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-cssanimations-csstransforms-csstransforms3d-csstransitions-canvas-canvastext-touch-shiv-mq-cssclasses-addtest-prefixed-teststyles-testprop-testallprops-prefixes-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function A(a){j.cssText=a}function B(a,b){return A(m.join(a+";")+(b||""))}function C(a,b){return typeof a===b}function D(a,b){return!!~(""+a).indexOf(b)}function E(a,b){for(var d in a){var e=a[d];if(!D(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function F(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:C(f,"function")?f.bind(d||b):f}return!1}function G(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+o.join(d+" ")+d).split(" ");return C(b,"string")||C(b,"undefined")?E(e,b):(e=(a+" "+p.join(d+" ")+d).split(" "),F(e,b,c))}var d="2.8.3",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m=" -webkit- -moz- -o- -ms- ".split(" "),n="Webkit Moz O ms",o=n.split(" "),p=n.toLowerCase().split(" "),q={},r={},s={},t=[],u=t.slice,v,w=function(a,c,d,e){var f,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),l.appendChild(j);return f=["&#173;",'<style id="s',h,'">',a,"</style>"].join(""),l.id=h,(m?l:n).innerHTML+=f,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=g.style.overflow,g.style.overflow="hidden",g.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),g.style.overflow=k),!!i},x=function(b){var c=a.matchMedia||a.msMatchMedia;if(c)return c(b)&&c(b).matches||!1;var d;return w("@media "+b+" { #"+h+" { position: absolute; } }",function(b){d=(a.getComputedStyle?getComputedStyle(b,null):b.currentStyle)["position"]=="absolute"}),d},y={}.hasOwnProperty,z;!C(y,"undefined")&&!C(y.call,"undefined")?z=function(a,b){return y.call(a,b)}:z=function(a,b){return b in a&&C(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=u.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(u.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(u.call(arguments)))};return e}),q.canvas=function(){var a=b.createElement("canvas");return!!a.getContext&&!!a.getContext("2d")},q.canvastext=function(){return!!e.canvas&&!!C(b.createElement("canvas").getContext("2d").fillText,"function")},q.touch=function(){var c;return"ontouchstart"in a||a.DocumentTouch&&b instanceof DocumentTouch?c=!0:w(["@media (",m.join("touch-enabled),("),h,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(a){c=a.offsetTop===9}),c},q.cssanimations=function(){return G("animationName")},q.csstransforms=function(){return!!G("transform")},q.csstransforms3d=function(){var a=!!G("perspective");return a&&"webkitPerspective"in g.style&&w("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}",function(b,c){a=b.offsetLeft===9&&b.offsetHeight===3}),a},q.csstransitions=function(){return G("transition")};for(var H in q)z(q,H)&&(v=H.toLowerCase(),e[v]=q[H](),t.push((e[v]?"":"no-")+v));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)z(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},A(""),i=k=null,function(a,b){function l(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function m(){var a=s.elements;return typeof a=="string"?a.split(" "):a}function n(a){var b=j[a[h]];return b||(b={},i++,a[h]=i,j[i]=b),b}function o(a,c,d){c||(c=b);if(k)return c.createElement(a);d||(d=n(c));var g;return d.cache[a]?g=d.cache[a].cloneNode():f.test(a)?g=(d.cache[a]=d.createElem(a)).cloneNode():g=d.createElem(a),g.canHaveChildren&&!e.test(a)&&!g.tagUrn?d.frag.appendChild(g):g}function p(a,c){a||(a=b);if(k)return a.createDocumentFragment();c=c||n(a);var d=c.frag.cloneNode(),e=0,f=m(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function q(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return s.shivMethods?o(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+m().join().replace(/[\w\-]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(s,b.frag)}function r(a){a||(a=b);var c=n(a);return s.shivCSS&&!g&&!c.hasCSS&&(c.hasCSS=!!l(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),k||q(a,c),a}var c="3.7.0",d=a.html5||{},e=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,f=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,g,h="_html5shiv",i=0,j={},k;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",g="hidden"in a,k=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){g=!0,k=!0}})();var s={elements:d.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",version:c,shivCSS:d.shivCSS!==!1,supportsUnknownElements:k,shivMethods:d.shivMethods!==!1,type:"default",shivDocument:r,createElement:o,createDocumentFragment:p};a.html5=s,r(b)}(this,b),e._version=d,e._prefixes=m,e._domPrefixes=p,e._cssomPrefixes=o,e.mq=x,e.testProp=function(a){return E([a])},e.testAllProps=G,e.testStyles=w,e.prefixed=function(a,b,c){return b?G(a,b,c):G(a,"pfx")},g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+t.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};

var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}};

/* 2. jQuery circliful plugin ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
(function ($) {

    $.fn.circliful = function (options, callback) {

        var settings = $.extend({
            // These are the defaults.
            startdegree: 0,
            fgcolor: "#556b2f",
            bgcolor: "#eee",
            fill: false,
            width: 0,
            dimension: 200,
            fontsize: 15,
            percent: 50,
            animationstep: 1.0,
            iconsize: '20px',
            iconcolor: '#999',
            border: 'default',
            complete: null,
            bordersize: 10
        }, options);

        var tmpObj = $("<span class='skin-color'></span>");
        tmpObj.appendTo("body");
        settings.fgcolor = tmpObj.css("color");
        tmpObj.remove();

        return this.each(function () {

            var customSettings = ["fgcolor", "bgcolor", "fill", "width", "dimension", "fontsize", "animationstep", "endPercent", "icon", "iconcolor", "iconsize", "border", "startdegree", "bordersize"];

            var customSettingsObj = {};
            var icon = '';
            var endPercent = 0;
            var obj = $(this);
            var fill = false;
            var text, info;

            obj.addClass('circliful');

            checkDataAttributes(obj);

            if (obj.data('text') != undefined) {
                text = obj.data('text');
                var decoded_text = Base64.decode( text );
                if ( Base64.encode( decoded_text ) == text ) {
                    text = unescape(decoded_text);
                }
                text = text.replace(/<script\b[^>]*>(.*?)<\/script>/i, "");

                if (obj.data('icon') != undefined) {
                    icon = $('<i></i>')
                        .addClass('fa ' + $(this).data('icon'))
                        .css({
                            'color': customSettingsObj.iconcolor,
                            'font-size': customSettingsObj.iconsize
                        });
                }

                if (obj.data('type') != undefined) {
                    type = $(this).data('type');

                    if (type == 'half') {
                        addCircleText(obj, 'circle-text-half', (customSettingsObj.dimension / 1.45));
                    } else {
                        addCircleText(obj, 'circle-text', customSettingsObj.dimension);
                    }
                } else {
                    addCircleText(obj, 'circle-text', customSettingsObj.dimension);
                }
            }

            if ($(this).data("total") != undefined && $(this).data("part") != undefined) {
                var total = $(this).data("total") / 100;

                percent = (($(this).data("part") / total) / 100).toFixed(3);
                endPercent = ($(this).data("part") / total).toFixed(3)
            } else {
                if ($(this).data("percent") != undefined) {
                    percent = $(this).data("percent") / 100;
                    endPercent = $(this).data("percent")
                } else {
                    percent = settings.percent / 100
                }
            }

            if ($(this).data('info') != undefined) {
                info = $(this).data('info');

                if ($(this).data('type') != undefined) {
                    type = $(this).data('type');

                    if (type == 'half') {
                        addInfoText(obj, 0.9);
                    } else {
                        addInfoText(obj, 1.25);
                    }
                } else {
                    addInfoText(obj, 1.25);
                }
            }

            $(this).width(customSettingsObj.dimension + 'px');

            var canvas = $('<canvas></canvas>').attr({
                width: customSettingsObj.dimension,
                height: customSettingsObj.dimension
            }).appendTo($(this)).get(0);

            var context = canvas.getContext('2d');
            var container = $(canvas).parent();
            var x = canvas.width / 2;
            var y = canvas.height / 2;
            var degrees = customSettingsObj.percent * 360.0;
            var radians = degrees * (Math.PI / 180);
            var radius = canvas.width / 2 - 2;
            var startAngle = 2.3 * Math.PI;
            var endAngle = 0;
            var counterClockwise = false;
            var curPerc = customSettingsObj.animationstep === 0.0 ? endPercent : 0.0;
            var curStep = Math.max(customSettingsObj.animationstep, 0.0);
            var circ = Math.PI * 2;
            var quart = Math.PI / 2;
            var type = '';
            var fireCallback = true;
            var additionalAngelPI = (customSettingsObj.startdegree / 180) * Math.PI;

            if ($(this).data('type') != undefined) {
                type = $(this).data('type');

                if (type == 'half') {
                    startAngle = 2.0 * Math.PI;
                    endAngle = 3.13;
                    circ = Math.PI;
                    quart = Math.PI / 0.996;
                }
            }

            


            /**
             * adds text to circle
             *
             * @param obj
             * @param cssClass
             * @param lineHeight
             */
            function addCircleText(obj, cssClass, lineHeight) {
                $("<span></span>")
                    .appendTo(obj)
                    .addClass(cssClass)
                    .html(text)
                    .prepend(icon)
                    .css({
                        'line-height': lineHeight + 'px',
                        'font-size': customSettingsObj.fontsize + 'px'
                    });
            }

            /**
             * adds info text to circle
             *
             * @param obj
             * @param factor
             */
            function addInfoText(obj, factor) {
                $('<span></span>')
                    .appendTo(obj)
                    .addClass('circle-info-half')
                    .css(
                        'line-height', (customSettingsObj.dimension * factor) + 'px'
                    )
                    .text(info);
            }

            /**
             * checks which data attributes are defined
             * @param obj
             */
            function checkDataAttributes(obj) {
                $.each(customSettings, function (index, attribute) {
                    if (obj.data(attribute) != undefined) {
                        customSettingsObj[attribute] = obj.data(attribute);
                    } else {
                        customSettingsObj[attribute] = $(settings).attr(attribute);
                    }

                    if (attribute == 'fill' && obj.data('fill') != undefined) {
                        fill = true;
                    }
                });
            }

            /**
             * animate foreground circle
             * @param current
             */
            function animate(current) {

                context.clearRect(0, 0, canvas.width, canvas.height);

                context.beginPath();

                var newRadius = radius;
                if (customSettingsObj.border == 'outline') {
                    newRadius = radius - customSettingsObj.width - customSettingsObj.bordersize / 2;
                } else {
                    newRadius = radius - customSettingsObj.bordersize / 2;
                }
                context.arc(x, y, newRadius, endAngle, startAngle, false);

                context.lineWidth = customSettingsObj.bordersize + 1;

                context.strokeStyle = customSettingsObj.bgcolor;
                context.stroke();

                if (fill) {
                    context.fillStyle = customSettingsObj.fill;
                    context.fill();
                }

                context.beginPath();

                newRadius = radius;
                if (customSettingsObj.border == 'inline') {
                    newRadius = radius - customSettingsObj.width / 2 - customSettingsObj.bordersize;
                } else if (customSettingsObj.border == 'outline') {
                    newRadius = radius - customSettingsObj.width / 2;
                } else if (customSettingsObj.border == 'middle') {
                    newRadius = radius - customSettingsObj.width / 2 - customSettingsObj.bordersize / 2 + customSettingsObj.width / 2;
                } else {
                    newRadius = radius - customSettingsObj.bordersize / 2;
                }
                context.arc(x, y, newRadius, -(quart) + additionalAngelPI, ((circ) * current) - quart + additionalAngelPI, false);

                if (customSettingsObj.border == 'outline' || customSettingsObj.border == 'inline' || customSettingsObj.border == 'middle') {
                    context.lineWidth = customSettingsObj.width;
                }

                context.strokeStyle = customSettingsObj.fgcolor;
                context.stroke();

                if (curPerc < endPercent) {
                    curPerc += curStep;
                    if (window.requestAnimationFrame) {
                        requestAnimationFrame(function () {
                            animate(Math.min(curPerc, endPercent) / 100);
                        }, obj);
                    } else {
                        setTimeout(function() {
                            animate(Math.min(curPerc, endPercent) / 100);
                        }, 30);
                    }
                }

                if (curPerc == endPercent && fireCallback && typeof(options) != "undefined") {
                    if ($.isFunction(options.complete)) {
                        options.complete();

                        fireCallback = false;
                    }
                }
            }

            //animate(curPerc / 100);

            $(this).waypoint(function() {
                animate(curPerc / 100);
                setTimeout(function() { $.waypoints('refresh'); }, 1000);
            }, {
                triggerOnce: true,
                offset: function() {
                    return $(window).height() - $(this).height() / 2;
                }
            });

        });
    };
}(jQuery));


/*!
 * Isotope PACKAGED v2.2.2
 *
 * Licensed GPLv3 for open source use
 * or Isotope Commercial License for commercial use
 *
 * http://isotope.metafizzy.co
 * Copyright 2015 Metafizzy
 */

!function(a){function b(){}function c(a){function c(b){b.prototype.option||(b.prototype.option=function(b){a.isPlainObject(b)&&(this.options=a.extend(!0,this.options,b))})}function e(b,c){a.fn[b]=function(e){if("string"==typeof e){for(var g=d.call(arguments,1),h=0,i=this.length;i>h;h++){var j=this[h],k=a.data(j,b);if(k)if(a.isFunction(k[e])&&"_"!==e.charAt(0)){var l=k[e].apply(k,g);if(void 0!==l)return l}else f("no such method '"+e+"' for "+b+" instance");else f("cannot call methods on "+b+" prior to initialization; attempted to call '"+e+"'")}return this}return this.each(function(){var d=a.data(this,b);d?(d.option(e),d._init()):(d=new c(this,e),a.data(this,b,d))})}}if(a){var f="undefined"==typeof console?b:function(a){console.error(a)};return a.bridget=function(a,b){c(b),e(a,b)},a.bridget}}var d=Array.prototype.slice;"function"==typeof define&&define.amd?define("jquery-bridget/jquery.bridget",["jquery"],c):c("object"==typeof exports?require("jquery"):a.jQuery)}(window),function(a){function b(b){var c=a.event;return c.target=c.target||c.srcElement||b,c}var c=document.documentElement,d=function(){};c.addEventListener?d=function(a,b,c){a.addEventListener(b,c,!1)}:c.attachEvent&&(d=function(a,c,d){a[c+d]=d.handleEvent?function(){var c=b(a);d.handleEvent.call(d,c)}:function(){var c=b(a);d.call(a,c)},a.attachEvent("on"+c,a[c+d])});var e=function(){};c.removeEventListener?e=function(a,b,c){a.removeEventListener(b,c,!1)}:c.detachEvent&&(e=function(a,b,c){a.detachEvent("on"+b,a[b+c]);try{delete a[b+c]}catch(d){a[b+c]=void 0}});var f={bind:d,unbind:e};"function"==typeof define&&define.amd?define("eventie/eventie",f):"object"==typeof exports?module.exports=f:a.eventie=f}(window),function(){"use strict";function a(){}function b(a,b){for(var c=a.length;c--;)if(a[c].listener===b)return c;return-1}function c(a){return function(){return this[a].apply(this,arguments)}}var d=a.prototype,e=this,f=e.EventEmitter;d.getListeners=function(a){var b,c,d=this._getEvents();if(a instanceof RegExp){b={};for(c in d)d.hasOwnProperty(c)&&a.test(c)&&(b[c]=d[c])}else b=d[a]||(d[a]=[]);return b},d.flattenListeners=function(a){var b,c=[];for(b=0;b<a.length;b+=1)c.push(a[b].listener);return c},d.getListenersAsObject=function(a){var b,c=this.getListeners(a);return c instanceof Array&&(b={},b[a]=c),b||c},d.addListener=function(a,c){var d,e=this.getListenersAsObject(a),f="object"==typeof c;for(d in e)e.hasOwnProperty(d)&&-1===b(e[d],c)&&e[d].push(f?c:{listener:c,once:!1});return this},d.on=c("addListener"),d.addOnceListener=function(a,b){return this.addListener(a,{listener:b,once:!0})},d.once=c("addOnceListener"),d.defineEvent=function(a){return this.getListeners(a),this},d.defineEvents=function(a){for(var b=0;b<a.length;b+=1)this.defineEvent(a[b]);return this},d.removeListener=function(a,c){var d,e,f=this.getListenersAsObject(a);for(e in f)f.hasOwnProperty(e)&&(d=b(f[e],c),-1!==d&&f[e].splice(d,1));return this},d.off=c("removeListener"),d.addListeners=function(a,b){return this.manipulateListeners(!1,a,b)},d.removeListeners=function(a,b){return this.manipulateListeners(!0,a,b)},d.manipulateListeners=function(a,b,c){var d,e,f=a?this.removeListener:this.addListener,g=a?this.removeListeners:this.addListeners;if("object"!=typeof b||b instanceof RegExp)for(d=c.length;d--;)f.call(this,b,c[d]);else for(d in b)b.hasOwnProperty(d)&&(e=b[d])&&("function"==typeof e?f.call(this,d,e):g.call(this,d,e));return this},d.removeEvent=function(a){var b,c=typeof a,d=this._getEvents();if("string"===c)delete d[a];else if(a instanceof RegExp)for(b in d)d.hasOwnProperty(b)&&a.test(b)&&delete d[b];else delete this._events;return this},d.removeAllListeners=c("removeEvent"),d.emitEvent=function(a,b){var c,d,e,f,g=this.getListenersAsObject(a);for(e in g)if(g.hasOwnProperty(e))for(d=g[e].length;d--;)c=g[e][d],c.once===!0&&this.removeListener(a,c.listener),f=c.listener.apply(this,b||[]),f===this._getOnceReturnValue()&&this.removeListener(a,c.listener);return this},d.trigger=c("emitEvent"),d.emit=function(a){var b=Array.prototype.slice.call(arguments,1);return this.emitEvent(a,b)},d.setOnceReturnValue=function(a){return this._onceReturnValue=a,this},d._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},d._getEvents=function(){return this._events||(this._events={})},a.noConflict=function(){return e.EventEmitter=f,a},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return a}):"object"==typeof module&&module.exports?module.exports=a:e.EventEmitter=a}.call(this),function(a){function b(a){if(a){if("string"==typeof d[a])return a;a=a.charAt(0).toUpperCase()+a.slice(1);for(var b,e=0,f=c.length;f>e;e++)if(b=c[e]+a,"string"==typeof d[b])return b}}var c="Webkit Moz ms Ms O".split(" "),d=document.documentElement.style;"function"==typeof define&&define.amd?define("get-style-property/get-style-property",[],function(){return b}):"object"==typeof exports?module.exports=b:a.getStyleProperty=b}(window),function(a,b){function c(a){var b=parseFloat(a),c=-1===a.indexOf("%")&&!isNaN(b);return c&&b}function d(){}function e(){for(var a={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},b=0,c=h.length;c>b;b++){var d=h[b];a[d]=0}return a}function f(b){function d(){if(!m){m=!0;var d=a.getComputedStyle;if(j=function(){var a=d?function(a){return d(a,null)}:function(a){return a.currentStyle};return function(b){var c=a(b);return c||g("Style returned "+c+". Are you running this code in a hidden iframe on Firefox? See http://bit.ly/getsizebug1"),c}}(),k=b("boxSizing")){var e=document.createElement("div");e.style.width="200px",e.style.padding="1px 2px 3px 4px",e.style.borderStyle="solid",e.style.borderWidth="1px 2px 3px 4px",e.style[k]="border-box";var f=document.body||document.documentElement;f.appendChild(e);var h=j(e);l=200===c(h.width),f.removeChild(e)}}}function f(a){if(d(),"string"==typeof a&&(a=document.querySelector(a)),a&&"object"==typeof a&&a.nodeType){var b=j(a);if("none"===b.display)return e();var f={};f.width=a.offsetWidth,f.height=a.offsetHeight;for(var g=f.isBorderBox=!(!k||!b[k]||"border-box"!==b[k]),m=0,n=h.length;n>m;m++){var o=h[m],p=b[o];p=i(a,p);var q=parseFloat(p);f[o]=isNaN(q)?0:q}var r=f.paddingLeft+f.paddingRight,s=f.paddingTop+f.paddingBottom,t=f.marginLeft+f.marginRight,u=f.marginTop+f.marginBottom,v=f.borderLeftWidth+f.borderRightWidth,w=f.borderTopWidth+f.borderBottomWidth,x=g&&l,y=c(b.width);y!==!1&&(f.width=y+(x?0:r+v));var z=c(b.height);return z!==!1&&(f.height=z+(x?0:s+w)),f.innerWidth=f.width-(r+v),f.innerHeight=f.height-(s+w),f.outerWidth=f.width+t,f.outerHeight=f.height+u,f}}function i(b,c){if(a.getComputedStyle||-1===c.indexOf("%"))return c;var d=b.style,e=d.left,f=b.runtimeStyle,g=f&&f.left;return g&&(f.left=b.currentStyle.left),d.left=c,c=d.pixelLeft,d.left=e,g&&(f.left=g),c}var j,k,l,m=!1;return f}var g="undefined"==typeof console?d:function(a){console.error(a)},h=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"];"function"==typeof define&&define.amd?define("get-size/get-size",["get-style-property/get-style-property"],f):"object"==typeof exports?module.exports=f(require("desandro-get-style-property")):a.getSize=f(a.getStyleProperty)}(window),function(a){function b(a){"function"==typeof a&&(b.isReady?a():g.push(a))}function c(a){var c="readystatechange"===a.type&&"complete"!==f.readyState;b.isReady||c||d()}function d(){b.isReady=!0;for(var a=0,c=g.length;c>a;a++){var d=g[a];d()}}function e(e){return"complete"===f.readyState?d():(e.bind(f,"DOMContentLoaded",c),e.bind(f,"readystatechange",c),e.bind(a,"load",c)),b}var f=a.document,g=[];b.isReady=!1,"function"==typeof define&&define.amd?define("doc-ready/doc-ready",["eventie/eventie"],e):"object"==typeof exports?module.exports=e(require("eventie")):a.docReady=e(a.eventie)}(window),function(a){"use strict";function b(a,b){return a[g](b)}function c(a){if(!a.parentNode){var b=document.createDocumentFragment();b.appendChild(a)}}function d(a,b){c(a);for(var d=a.parentNode.querySelectorAll(b),e=0,f=d.length;f>e;e++)if(d[e]===a)return!0;return!1}function e(a,d){return c(a),b(a,d)}var f,g=function(){if(a.matches)return"matches";if(a.matchesSelector)return"matchesSelector";for(var b=["webkit","moz","ms","o"],c=0,d=b.length;d>c;c++){var e=b[c],f=e+"MatchesSelector";if(a[f])return f}}();if(g){var h=document.createElement("div"),i=b(h,"div");f=i?b:e}else f=d;"function"==typeof define&&define.amd?define("matches-selector/matches-selector",[],function(){return f}):"object"==typeof exports?module.exports=f:window.matchesSelector=f}(Element.prototype),function(a,b){"use strict";"function"==typeof define&&define.amd?define("fizzy-ui-utils/utils",["doc-ready/doc-ready","matches-selector/matches-selector"],function(c,d){return b(a,c,d)}):"object"==typeof exports?module.exports=b(a,require("doc-ready"),require("desandro-matches-selector")):a.fizzyUIUtils=b(a,a.docReady,a.matchesSelector)}(window,function(a,b,c){var d={};d.extend=function(a,b){for(var c in b)a[c]=b[c];return a},d.modulo=function(a,b){return(a%b+b)%b};var e=Object.prototype.toString;d.isArray=function(a){return"[object Array]"==e.call(a)},d.makeArray=function(a){var b=[];if(d.isArray(a))b=a;else if(a&&"number"==typeof a.length)for(var c=0,e=a.length;e>c;c++)b.push(a[c]);else b.push(a);return b},d.indexOf=Array.prototype.indexOf?function(a,b){return a.indexOf(b)}:function(a,b){for(var c=0,d=a.length;d>c;c++)if(a[c]===b)return c;return-1},d.removeFrom=function(a,b){var c=d.indexOf(a,b);-1!=c&&a.splice(c,1)},d.isElement="function"==typeof HTMLElement||"object"==typeof HTMLElement?function(a){return a instanceof HTMLElement}:function(a){return a&&"object"==typeof a&&1==a.nodeType&&"string"==typeof a.nodeName},d.setText=function(){function a(a,c){b=b||(void 0!==document.documentElement.textContent?"textContent":"innerText"),a[b]=c}var b;return a}(),d.getParent=function(a,b){for(;a!=document.body;)if(a=a.parentNode,c(a,b))return a},d.getQueryElement=function(a){return"string"==typeof a?document.querySelector(a):a},d.handleEvent=function(a){var b="on"+a.type;this[b]&&this[b](a)},d.filterFindElements=function(a,b){a=d.makeArray(a);for(var e=[],f=0,g=a.length;g>f;f++){var h=a[f];if(d.isElement(h))if(b){c(h,b)&&e.push(h);for(var i=h.querySelectorAll(b),j=0,k=i.length;k>j;j++)e.push(i[j])}else e.push(h)}return e},d.debounceMethod=function(a,b,c){var d=a.prototype[b],e=b+"Timeout";a.prototype[b]=function(){var a=this[e];a&&clearTimeout(a);var b=arguments,f=this;this[e]=setTimeout(function(){d.apply(f,b),delete f[e]},c||100)}},d.toDashed=function(a){return a.replace(/(.)([A-Z])/g,function(a,b,c){return b+"-"+c}).toLowerCase()};var f=a.console;return d.htmlInit=function(c,e){b(function(){for(var b=d.toDashed(e),g=document.querySelectorAll(".js-"+b),h="data-"+b+"-options",i=0,j=g.length;j>i;i++){var k,l=g[i],m=l.getAttribute(h);try{k=m&&JSON.parse(m)}catch(n){f&&f.error("Error parsing "+h+" on "+l.nodeName.toLowerCase()+(l.id?"#"+l.id:"")+": "+n);continue}var o=new c(l,k),p=a.jQuery;p&&p.data(l,e,o)}})},d}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("outlayer/item",["eventEmitter/EventEmitter","get-size/get-size","get-style-property/get-style-property","fizzy-ui-utils/utils"],function(c,d,e,f){return b(a,c,d,e,f)}):"object"==typeof exports?module.exports=b(a,require("wolfy87-eventemitter"),require("get-size"),require("desandro-get-style-property"),require("fizzy-ui-utils")):(a.Outlayer={},a.Outlayer.Item=b(a,a.EventEmitter,a.getSize,a.getStyleProperty,a.fizzyUIUtils))}(window,function(a,b,c,d,e){"use strict";function f(a){for(var b in a)return!1;return b=null,!0}function g(a,b){a&&(this.element=a,this.layout=b,this.position={x:0,y:0},this._create())}function h(a){return a.replace(/([A-Z])/g,function(a){return"-"+a.toLowerCase()})}var i=a.getComputedStyle,j=i?function(a){return i(a,null)}:function(a){return a.currentStyle},k=d("transition"),l=d("transform"),m=k&&l,n=!!d("perspective"),o={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"otransitionend",transition:"transitionend"}[k],p=["transform","transition","transitionDuration","transitionProperty"],q=function(){for(var a={},b=0,c=p.length;c>b;b++){var e=p[b],f=d(e);f&&f!==e&&(a[e]=f)}return a}();e.extend(g.prototype,b.prototype),g.prototype._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},g.prototype.handleEvent=function(a){var b="on"+a.type;this[b]&&this[b](a)},g.prototype.getSize=function(){this.size=c(this.element)},g.prototype.css=function(a){var b=this.element.style;for(var c in a){var d=q[c]||c;b[d]=a[c]}},g.prototype.getPosition=function(){var a=j(this.element),b=this.layout.options,c=b.isOriginLeft,d=b.isOriginTop,e=a[c?"left":"right"],f=a[d?"top":"bottom"],g=this.layout.size,h=-1!=e.indexOf("%")?parseFloat(e)/100*g.width:parseInt(e,10),i=-1!=f.indexOf("%")?parseFloat(f)/100*g.height:parseInt(f,10);h=isNaN(h)?0:h,i=isNaN(i)?0:i,h-=c?g.paddingLeft:g.paddingRight,i-=d?g.paddingTop:g.paddingBottom,this.position.x=h,this.position.y=i},g.prototype.layoutPosition=function(){var a=this.layout.size,b=this.layout.options,c={},d=b.isOriginLeft?"paddingLeft":"paddingRight",e=b.isOriginLeft?"left":"right",f=b.isOriginLeft?"right":"left",g=this.position.x+a[d];c[e]=this.getXValue(g),c[f]="";var h=b.isOriginTop?"paddingTop":"paddingBottom",i=b.isOriginTop?"top":"bottom",j=b.isOriginTop?"bottom":"top",k=this.position.y+a[h];c[i]=this.getYValue(k),c[j]="",this.css(c),this.emitEvent("layout",[this])},g.prototype.getXValue=function(a){var b=this.layout.options;return b.percentPosition&&!b.isHorizontal?a/this.layout.size.width*100+"%":a+"px"},g.prototype.getYValue=function(a){var b=this.layout.options;return b.percentPosition&&b.isHorizontal?a/this.layout.size.height*100+"%":a+"px"},g.prototype._transitionTo=function(a,b){this.getPosition();var c=this.position.x,d=this.position.y,e=parseInt(a,10),f=parseInt(b,10),g=e===this.position.x&&f===this.position.y;if(this.setPosition(a,b),g&&!this.isTransitioning)return void this.layoutPosition();var h=a-c,i=b-d,j={};j.transform=this.getTranslate(h,i),this.transition({to:j,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})},g.prototype.getTranslate=function(a,b){var c=this.layout.options;return a=c.isOriginLeft?a:-a,b=c.isOriginTop?b:-b,n?"translate3d("+a+"px, "+b+"px, 0)":"translate("+a+"px, "+b+"px)"},g.prototype.goTo=function(a,b){this.setPosition(a,b),this.layoutPosition()},g.prototype.moveTo=m?g.prototype._transitionTo:g.prototype.goTo,g.prototype.setPosition=function(a,b){this.position.x=parseInt(a,10),this.position.y=parseInt(b,10)},g.prototype._nonTransition=function(a){this.css(a.to),a.isCleaning&&this._removeStyles(a.to);for(var b in a.onTransitionEnd)a.onTransitionEnd[b].call(this)},g.prototype._transition=function(a){if(!parseFloat(this.layout.options.transitionDuration))return void this._nonTransition(a);var b=this._transn;for(var c in a.onTransitionEnd)b.onEnd[c]=a.onTransitionEnd[c];for(c in a.to)b.ingProperties[c]=!0,a.isCleaning&&(b.clean[c]=!0);if(a.from){this.css(a.from);var d=this.element.offsetHeight;d=null}this.enableTransition(a.to),this.css(a.to),this.isTransitioning=!0};var r="opacity,"+h(q.transform||"transform");g.prototype.enableTransition=function(){this.isTransitioning||(this.css({transitionProperty:r,transitionDuration:this.layout.options.transitionDuration}),this.element.addEventListener(o,this,!1))},g.prototype.transition=g.prototype[k?"_transition":"_nonTransition"],g.prototype.onwebkitTransitionEnd=function(a){this.ontransitionend(a)},g.prototype.onotransitionend=function(a){this.ontransitionend(a)};var s={"-webkit-transform":"transform","-moz-transform":"transform","-o-transform":"transform"};g.prototype.ontransitionend=function(a){if(a.target===this.element){var b=this._transn,c=s[a.propertyName]||a.propertyName;if(delete b.ingProperties[c],f(b.ingProperties)&&this.disableTransition(),c in b.clean&&(this.element.style[a.propertyName]="",delete b.clean[c]),c in b.onEnd){var d=b.onEnd[c];d.call(this),delete b.onEnd[c]}this.emitEvent("transitionEnd",[this])}},g.prototype.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(o,this,!1),this.isTransitioning=!1},g.prototype._removeStyles=function(a){var b={};for(var c in a)b[c]="";this.css(b)};var t={transitionProperty:"",transitionDuration:""};return g.prototype.removeTransitionStyles=function(){this.css(t)},g.prototype.removeElem=function(){this.element.parentNode.removeChild(this.element),this.css({display:""}),this.emitEvent("remove",[this])},g.prototype.remove=function(){if(!k||!parseFloat(this.layout.options.transitionDuration))return void this.removeElem();var a=this;this.once("transitionEnd",function(){a.removeElem()}),this.hide()},g.prototype.reveal=function(){delete this.isHidden,this.css({display:""});var a=this.layout.options,b={},c=this.getHideRevealTransitionEndProperty("visibleStyle");b[c]=this.onRevealTransitionEnd,this.transition({from:a.hiddenStyle,to:a.visibleStyle,isCleaning:!0,onTransitionEnd:b})},g.prototype.onRevealTransitionEnd=function(){this.isHidden||this.emitEvent("reveal")},g.prototype.getHideRevealTransitionEndProperty=function(a){var b=this.layout.options[a];if(b.opacity)return"opacity";for(var c in b)return c},g.prototype.hide=function(){this.isHidden=!0,this.css({display:""});var a=this.layout.options,b={},c=this.getHideRevealTransitionEndProperty("hiddenStyle");b[c]=this.onHideTransitionEnd,this.transition({from:a.visibleStyle,to:a.hiddenStyle,isCleaning:!0,onTransitionEnd:b})},g.prototype.onHideTransitionEnd=function(){this.isHidden&&(this.css({display:"none"}),this.emitEvent("hide"))},g.prototype.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},g}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("outlayer/outlayer",["eventie/eventie","eventEmitter/EventEmitter","get-size/get-size","fizzy-ui-utils/utils","./item"],function(c,d,e,f,g){return b(a,c,d,e,f,g)}):"object"==typeof exports?module.exports=b(a,require("eventie"),require("wolfy87-eventemitter"),require("get-size"),require("fizzy-ui-utils"),require("./item")):a.Outlayer=b(a,a.eventie,a.EventEmitter,a.getSize,a.fizzyUIUtils,a.Outlayer.Item)}(window,function(a,b,c,d,e,f){"use strict";function g(a,b){var c=e.getQueryElement(a);if(!c)return void(h&&h.error("Bad element for "+this.constructor.namespace+": "+(c||a)));this.element=c,i&&(this.$element=i(this.element)),this.options=e.extend({},this.constructor.defaults),this.option(b);var d=++k;this.element.outlayerGUID=d,l[d]=this,this._create(),this.options.isInitLayout&&this.layout()}var h=a.console,i=a.jQuery,j=function(){},k=0,l={};return g.namespace="outlayer",g.Item=f,g.defaults={containerStyle:{position:"relative"},isInitLayout:!0,isOriginLeft:!0,isOriginTop:!0,isResizeBound:!0,isResizingContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}},e.extend(g.prototype,c.prototype),g.prototype.option=function(a){e.extend(this.options,a)},g.prototype._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),e.extend(this.element.style,this.options.containerStyle),this.options.isResizeBound&&this.bindResize()},g.prototype.reloadItems=function(){this.items=this._itemize(this.element.children)},g.prototype._itemize=function(a){for(var b=this._filterFindItemElements(a),c=this.constructor.Item,d=[],e=0,f=b.length;f>e;e++){var g=b[e],h=new c(g,this);d.push(h)}return d},g.prototype._filterFindItemElements=function(a){return e.filterFindElements(a,this.options.itemSelector)},g.prototype.getItemElements=function(){for(var a=[],b=0,c=this.items.length;c>b;b++)a.push(this.items[b].element);return a},g.prototype.layout=function(){this._resetLayout(),this._manageStamps();var a=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;this.layoutItems(this.items,a),this._isLayoutInited=!0},g.prototype._init=g.prototype.layout,g.prototype._resetLayout=function(){this.getSize()},g.prototype.getSize=function(){this.size=d(this.element)},g.prototype._getMeasurement=function(a,b){var c,f=this.options[a];f?("string"==typeof f?c=this.element.querySelector(f):e.isElement(f)&&(c=f),this[a]=c?d(c)[b]:f):this[a]=0},g.prototype.layoutItems=function(a,b){a=this._getItemsForLayout(a),this._layoutItems(a,b),this._postLayout()},g.prototype._getItemsForLayout=function(a){for(var b=[],c=0,d=a.length;d>c;c++){var e=a[c];e.isIgnored||b.push(e)}return b},g.prototype._layoutItems=function(a,b){if(this._emitCompleteOnItems("layout",a),a&&a.length){for(var c=[],d=0,e=a.length;e>d;d++){var f=a[d],g=this._getItemLayoutPosition(f);g.item=f,g.isInstant=b||f.isLayoutInstant,c.push(g)}this._processLayoutQueue(c)}},g.prototype._getItemLayoutPosition=function(){return{x:0,y:0}},g.prototype._processLayoutQueue=function(a){for(var b=0,c=a.length;c>b;b++){var d=a[b];this._positionItem(d.item,d.x,d.y,d.isInstant)}},g.prototype._positionItem=function(a,b,c,d){d?a.goTo(b,c):a.moveTo(b,c)},g.prototype._postLayout=function(){this.resizeContainer()},g.prototype.resizeContainer=function(){if(this.options.isResizingContainer){var a=this._getContainerSize();a&&(this._setContainerMeasure(a.width,!0),this._setContainerMeasure(a.height,!1))}},g.prototype._getContainerSize=j,g.prototype._setContainerMeasure=function(a,b){if(void 0!==a){var c=this.size;c.isBorderBox&&(a+=b?c.paddingLeft+c.paddingRight+c.borderLeftWidth+c.borderRightWidth:c.paddingBottom+c.paddingTop+c.borderTopWidth+c.borderBottomWidth),a=Math.max(a,0),this.element.style[b?"width":"height"]=a+"px"}},g.prototype._emitCompleteOnItems=function(a,b){function c(){e.dispatchEvent(a+"Complete",null,[b])}function d(){g++,g===f&&c()}var e=this,f=b.length;if(!b||!f)return void c();for(var g=0,h=0,i=b.length;i>h;h++){var j=b[h];j.once(a,d)}},g.prototype.dispatchEvent=function(a,b,c){var d=b?[b].concat(c):c;if(this.emitEvent(a,d),i)if(this.$element=this.$element||i(this.element),b){var e=i.Event(b);e.type=a,this.$element.trigger(e,c)}else this.$element.trigger(a,c)},g.prototype.ignore=function(a){var b=this.getItem(a);b&&(b.isIgnored=!0)},g.prototype.unignore=function(a){var b=this.getItem(a);b&&delete b.isIgnored},g.prototype.stamp=function(a){if(a=this._find(a)){this.stamps=this.stamps.concat(a);for(var b=0,c=a.length;c>b;b++){var d=a[b];this.ignore(d)}}},g.prototype.unstamp=function(a){if(a=this._find(a))for(var b=0,c=a.length;c>b;b++){var d=a[b];e.removeFrom(this.stamps,d),this.unignore(d)}},g.prototype._find=function(a){return a?("string"==typeof a&&(a=this.element.querySelectorAll(a)),a=e.makeArray(a)):void 0},g.prototype._manageStamps=function(){if(this.stamps&&this.stamps.length){this._getBoundingRect();for(var a=0,b=this.stamps.length;b>a;a++){var c=this.stamps[a];this._manageStamp(c)}}},g.prototype._getBoundingRect=function(){var a=this.element.getBoundingClientRect(),b=this.size;this._boundingRect={left:a.left+b.paddingLeft+b.borderLeftWidth,top:a.top+b.paddingTop+b.borderTopWidth,right:a.right-(b.paddingRight+b.borderRightWidth),bottom:a.bottom-(b.paddingBottom+b.borderBottomWidth)}},g.prototype._manageStamp=j,g.prototype._getElementOffset=function(a){var b=a.getBoundingClientRect(),c=this._boundingRect,e=d(a),f={left:b.left-c.left-e.marginLeft,top:b.top-c.top-e.marginTop,right:c.right-b.right-e.marginRight,bottom:c.bottom-b.bottom-e.marginBottom};return f},g.prototype.handleEvent=function(a){var b="on"+a.type;this[b]&&this[b](a)},g.prototype.bindResize=function(){this.isResizeBound||(b.bind(a,"resize",this),this.isResizeBound=!0)},g.prototype.unbindResize=function(){this.isResizeBound&&b.unbind(a,"resize",this),this.isResizeBound=!1},g.prototype.onresize=function(){function a(){b.resize(),delete b.resizeTimeout}this.resizeTimeout&&clearTimeout(this.resizeTimeout);var b=this;this.resizeTimeout=setTimeout(a,100)},g.prototype.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},g.prototype.needsResizeLayout=function(){var a=d(this.element),b=this.size&&a;return b&&a.innerWidth!==this.size.innerWidth},g.prototype.addItems=function(a){var b=this._itemize(a);return b.length&&(this.items=this.items.concat(b)),b},g.prototype.appended=function(a){var b=this.addItems(a);b.length&&(this.layoutItems(b,!0),this.reveal(b))},g.prototype.prepended=function(a){var b=this._itemize(a);if(b.length){var c=this.items.slice(0);this.items=b.concat(c),this._resetLayout(),this._manageStamps(),this.layoutItems(b,!0),this.reveal(b),this.layoutItems(c)}},g.prototype.reveal=function(a){this._emitCompleteOnItems("reveal",a);for(var b=a&&a.length,c=0;b&&b>c;c++){var d=a[c];d.reveal()}},g.prototype.hide=function(a){this._emitCompleteOnItems("hide",a);for(var b=a&&a.length,c=0;b&&b>c;c++){var d=a[c];d.hide()}},g.prototype.revealItemElements=function(a){var b=this.getItems(a);this.reveal(b)},g.prototype.hideItemElements=function(a){var b=this.getItems(a);this.hide(b)},g.prototype.getItem=function(a){for(var b=0,c=this.items.length;c>b;b++){var d=this.items[b];if(d.element===a)return d}},g.prototype.getItems=function(a){a=e.makeArray(a);for(var b=[],c=0,d=a.length;d>c;c++){var f=a[c],g=this.getItem(f);g&&b.push(g)}return b},g.prototype.remove=function(a){var b=this.getItems(a);if(this._emitCompleteOnItems("remove",b),b&&b.length)for(var c=0,d=b.length;d>c;c++){var f=b[c];f.remove(),e.removeFrom(this.items,f)}},g.prototype.destroy=function(){var a=this.element.style;a.height="",a.position="",a.width="";for(var b=0,c=this.items.length;c>b;b++){var d=this.items[b];d.destroy()}this.unbindResize();var e=this.element.outlayerGUID;delete l[e],delete this.element.outlayerGUID,i&&i.removeData(this.element,this.constructor.namespace)},g.data=function(a){a=e.getQueryElement(a);var b=a&&a.outlayerGUID;return b&&l[b]},g.create=function(a,b){function c(){g.apply(this,arguments)}return Object.create?c.prototype=Object.create(g.prototype):e.extend(c.prototype,g.prototype),c.prototype.constructor=c,c.defaults=e.extend({},g.defaults),e.extend(c.defaults,b),c.prototype.settings={},c.namespace=a,c.data=g.data,c.Item=function(){f.apply(this,arguments)},c.Item.prototype=new f,e.htmlInit(c,a),i&&i.bridget&&i.bridget(a,c),c},g.Item=f,g}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("isotope/js/item",["outlayer/outlayer"],b):"object"==typeof exports?module.exports=b(require("outlayer")):(a.Isotope=a.Isotope||{},a.Isotope.Item=b(a.Outlayer))}(window,function(a){"use strict";function b(){a.Item.apply(this,arguments)}b.prototype=new a.Item,b.prototype._create=function(){this.id=this.layout.itemGUID++,a.Item.prototype._create.call(this),this.sortData={}},b.prototype.updateSortData=function(){if(!this.isIgnored){this.sortData.id=this.id,this.sortData["original-order"]=this.id,this.sortData.random=Math.random();var a=this.layout.options.getSortData,b=this.layout._sorters;for(var c in a){var d=b[c];this.sortData[c]=d(this.element,this)}}};var c=b.prototype.destroy;return b.prototype.destroy=function(){c.apply(this,arguments),this.css({display:""})},b}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("isotope/js/layout-mode",["get-size/get-size","outlayer/outlayer"],b):"object"==typeof exports?module.exports=b(require("get-size"),require("outlayer")):(a.Isotope=a.Isotope||{},a.Isotope.LayoutMode=b(a.getSize,a.Outlayer))}(window,function(a,b){"use strict";function c(a){this.isotope=a,a&&(this.options=a.options[this.namespace],this.element=a.element,this.items=a.filteredItems,this.size=a.size)}return function(){function a(a){return function(){return b.prototype[a].apply(this.isotope,arguments)}}for(var d=["_resetLayout","_getItemLayoutPosition","_manageStamp","_getContainerSize","_getElementOffset","needsResizeLayout"],e=0,f=d.length;f>e;e++){var g=d[e];c.prototype[g]=a(g)}}(),c.prototype.needsVerticalResizeLayout=function(){var b=a(this.isotope.element),c=this.isotope.size&&b;return c&&b.innerHeight!=this.isotope.size.innerHeight},c.prototype._getMeasurement=function(){this.isotope._getMeasurement.apply(this,arguments)},c.prototype.getColumnWidth=function(){this.getSegmentSize("column","Width")},c.prototype.getRowHeight=function(){this.getSegmentSize("row","Height")},c.prototype.getSegmentSize=function(a,b){var c=a+b,d="outer"+b;if(this._getMeasurement(c,d),!this[c]){var e=this.getFirstItemSize();this[c]=e&&e[d]||this.isotope.size["inner"+b]}},c.prototype.getFirstItemSize=function(){var b=this.isotope.filteredItems[0];return b&&b.element&&a(b.element)},c.prototype.layout=function(){this.isotope.layout.apply(this.isotope,arguments)},c.prototype.getSize=function(){this.isotope.getSize(),this.size=this.isotope.size},c.modes={},c.create=function(a,b){function d(){c.apply(this,arguments)}return d.prototype=new c,b&&(d.options=b),d.prototype.namespace=a,c.modes[a]=d,d},c}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("masonry/masonry",["outlayer/outlayer","get-size/get-size","fizzy-ui-utils/utils"],b):"object"==typeof exports?module.exports=b(require("outlayer"),require("get-size"),require("fizzy-ui-utils")):a.Masonry=b(a.Outlayer,a.getSize,a.fizzyUIUtils)}(window,function(a,b,c){var d=a.create("masonry");return d.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns();var a=this.cols;for(this.colYs=[];a--;)this.colYs.push(0);this.maxY=0},d.prototype.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var a=this.items[0],c=a&&a.element;this.columnWidth=c&&b(c).outerWidth||this.containerWidth}var d=this.columnWidth+=this.gutter,e=this.containerWidth+this.gutter,f=e/d,g=d-e%d,h=g&&1>g?"round":"floor";f=Math[h](f),this.cols=Math.max(f,1)},d.prototype.getContainerWidth=function(){var a=this.options.isFitWidth?this.element.parentNode:this.element,c=b(a);this.containerWidth=c&&c.innerWidth},d.prototype._getItemLayoutPosition=function(a){a.getSize();var b=a.size.outerWidth%this.columnWidth,d=b&&1>b?"round":"ceil",e=Math[d](a.size.outerWidth/this.columnWidth);e=Math.min(e,this.cols);for(var f=this._getColGroup(e),g=Math.min.apply(Math,f),h=c.indexOf(f,g),i={x:this.columnWidth*h,y:g},j=g+a.size.outerHeight,k=this.cols+1-f.length,l=0;k>l;l++)this.colYs[h+l]=j;return i},d.prototype._getColGroup=function(a){if(2>a)return this.colYs;for(var b=[],c=this.cols+1-a,d=0;c>d;d++){var e=this.colYs.slice(d,d+a);b[d]=Math.max.apply(Math,e)}return b},d.prototype._manageStamp=function(a){var c=b(a),d=this._getElementOffset(a),e=this.options.isOriginLeft?d.left:d.right,f=e+c.outerWidth,g=Math.floor(e/this.columnWidth);g=Math.max(0,g);var h=Math.floor(f/this.columnWidth);h-=f%this.columnWidth?0:1,h=Math.min(this.cols-1,h);for(var i=(this.options.isOriginTop?d.top:d.bottom)+c.outerHeight,j=g;h>=j;j++)this.colYs[j]=Math.max(i,this.colYs[j])},d.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var a={height:this.maxY};return this.options.isFitWidth&&(a.width=this._getContainerFitWidth()),a},d.prototype._getContainerFitWidth=function(){for(var a=0,b=this.cols;--b&&0===this.colYs[b];)a++;return(this.cols-a)*this.columnWidth-this.gutter},d.prototype.needsResizeLayout=function(){var a=this.containerWidth;return this.getContainerWidth(),a!==this.containerWidth},d}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("isotope/js/layout-modes/masonry",["../layout-mode","masonry/masonry"],b):"object"==typeof exports?module.exports=b(require("../layout-mode"),require("masonry-layout")):b(a.Isotope.LayoutMode,a.Masonry)}(window,function(a,b){"use strict";function c(a,b){for(var c in b)a[c]=b[c];return a}var d=a.create("masonry"),e=d.prototype._getElementOffset,f=d.prototype.layout,g=d.prototype._getMeasurement;
c(d.prototype,b.prototype),d.prototype._getElementOffset=e,d.prototype.layout=f,d.prototype._getMeasurement=g;var h=d.prototype.measureColumns;d.prototype.measureColumns=function(){this.items=this.isotope.filteredItems,h.call(this)};var i=d.prototype._manageStamp;return d.prototype._manageStamp=function(){this.options.isOriginLeft=this.isotope.options.isOriginLeft,this.options.isOriginTop=this.isotope.options.isOriginTop,i.apply(this,arguments)},d}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("isotope/js/layout-modes/fit-rows",["../layout-mode"],b):"object"==typeof exports?module.exports=b(require("../layout-mode")):b(a.Isotope.LayoutMode)}(window,function(a){"use strict";var b=a.create("fitRows");return b.prototype._resetLayout=function(){this.x=0,this.y=0,this.maxY=0,this._getMeasurement("gutter","outerWidth")},b.prototype._getItemLayoutPosition=function(a){a.getSize();var b=a.size.outerWidth+this.gutter,c=this.isotope.size.innerWidth+this.gutter;0!==this.x&&b+this.x>c&&(this.x=0,this.y=this.maxY);var d={x:this.x,y:this.y};return this.maxY=Math.max(this.maxY,this.y+a.size.outerHeight),this.x+=b,d},b.prototype._getContainerSize=function(){return{height:this.maxY}},b}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("isotope/js/layout-modes/vertical",["../layout-mode"],b):"object"==typeof exports?module.exports=b(require("../layout-mode")):b(a.Isotope.LayoutMode)}(window,function(a){"use strict";var b=a.create("vertical",{horizontalAlignment:0});return b.prototype._resetLayout=function(){this.y=0},b.prototype._getItemLayoutPosition=function(a){a.getSize();var b=(this.isotope.size.innerWidth-a.size.outerWidth)*this.options.horizontalAlignment,c=this.y;return this.y+=a.size.outerHeight,{x:b,y:c}},b.prototype._getContainerSize=function(){return{height:this.y}},b}),function(a,b){"use strict";"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size","matches-selector/matches-selector","fizzy-ui-utils/utils","isotope/js/item","isotope/js/layout-mode","isotope/js/layout-modes/masonry","isotope/js/layout-modes/fit-rows","isotope/js/layout-modes/vertical"],function(c,d,e,f,g,h){return b(a,c,d,e,f,g,h)}):"object"==typeof exports?module.exports=b(a,require("outlayer"),require("get-size"),require("desandro-matches-selector"),require("fizzy-ui-utils"),require("./item"),require("./layout-mode"),require("./layout-modes/masonry"),require("./layout-modes/fit-rows"),require("./layout-modes/vertical")):a.Isotope=b(a,a.Outlayer,a.getSize,a.matchesSelector,a.fizzyUIUtils,a.Isotope.Item,a.Isotope.LayoutMode)}(window,function(a,b,c,d,e,f,g){function h(a,b){return function(c,d){for(var e=0,f=a.length;f>e;e++){var g=a[e],h=c.sortData[g],i=d.sortData[g];if(h>i||i>h){var j=void 0!==b[g]?b[g]:b,k=j?1:-1;return(h>i?1:-1)*k}}return 0}}var i=a.jQuery,j=String.prototype.trim?function(a){return a.trim()}:function(a){return a.replace(/^\s+|\s+$/g,"")},k=document.documentElement,l=k.textContent?function(a){return a.textContent}:function(a){return a.innerText},m=b.create("isotope",{layoutMode:"masonry",isJQueryFiltering:!0,sortAscending:!0});m.Item=f,m.LayoutMode=g,m.prototype._create=function(){this.itemGUID=0,this._sorters={},this._getSorters(),b.prototype._create.call(this),this.modes={},this.filteredItems=this.items,this.sortHistory=["original-order"];for(var a in g.modes)this._initLayoutMode(a)},m.prototype.reloadItems=function(){this.itemGUID=0,b.prototype.reloadItems.call(this)},m.prototype._itemize=function(){for(var a=b.prototype._itemize.apply(this,arguments),c=0,d=a.length;d>c;c++){var e=a[c];e.id=this.itemGUID++}return this._updateItemsSortData(a),a},m.prototype._initLayoutMode=function(a){var b=g.modes[a],c=this.options[a]||{};this.options[a]=b.options?e.extend(b.options,c):c,this.modes[a]=new b(this)},m.prototype.layout=function(){return!this._isLayoutInited&&this.options.isInitLayout?void this.arrange():void this._layout()},m.prototype._layout=function(){var a=this._getIsInstant();this._resetLayout(),this._manageStamps(),this.layoutItems(this.filteredItems,a),this._isLayoutInited=!0},m.prototype.arrange=function(a){function b(){d.reveal(c.needReveal),d.hide(c.needHide)}this.option(a),this._getIsInstant();var c=this._filter(this.items);this.filteredItems=c.matches;var d=this;this._bindArrangeComplete(),this._isInstant?this._noTransition(b):b(),this._sort(),this._layout()},m.prototype._init=m.prototype.arrange,m.prototype._getIsInstant=function(){var a=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;return this._isInstant=a,a},m.prototype._bindArrangeComplete=function(){function a(){b&&c&&d&&e.dispatchEvent("arrangeComplete",null,[e.filteredItems])}var b,c,d,e=this;this.once("layoutComplete",function(){b=!0,a()}),this.once("hideComplete",function(){c=!0,a()}),this.once("revealComplete",function(){d=!0,a()})},m.prototype._filter=function(a){var b=this.options.filter;b=b||"*";for(var c=[],d=[],e=[],f=this._getFilterTest(b),g=0,h=a.length;h>g;g++){var i=a[g];if(!i.isIgnored){var j=f(i);j&&c.push(i),j&&i.isHidden?d.push(i):j||i.isHidden||e.push(i)}}return{matches:c,needReveal:d,needHide:e}},m.prototype._getFilterTest=function(a){return i&&this.options.isJQueryFiltering?function(b){return i(b.element).is(a)}:"function"==typeof a?function(b){return a(b.element)}:function(b){return d(b.element,a)}},m.prototype.updateSortData=function(a){var b;a?(a=e.makeArray(a),b=this.getItems(a)):b=this.items,this._getSorters(),this._updateItemsSortData(b)},m.prototype._getSorters=function(){var a=this.options.getSortData;for(var b in a){var c=a[b];this._sorters[b]=n(c)}},m.prototype._updateItemsSortData=function(a){for(var b=a&&a.length,c=0;b&&b>c;c++){var d=a[c];d.updateSortData()}};var n=function(){function a(a){if("string"!=typeof a)return a;var c=j(a).split(" "),d=c[0],e=d.match(/^\[(.+)\]$/),f=e&&e[1],g=b(f,d),h=m.sortDataParsers[c[1]];return a=h?function(a){return a&&h(g(a))}:function(a){return a&&g(a)}}function b(a,b){var c;return c=a?function(b){return b.getAttribute(a)}:function(a){var c=a.querySelector(b);return c&&l(c)}}return a}();m.sortDataParsers={parseInt:function(a){return parseInt(a,10)},parseFloat:function(a){return parseFloat(a)}},m.prototype._sort=function(){var a=this.options.sortBy;if(a){var b=[].concat.apply(a,this.sortHistory),c=h(b,this.options.sortAscending);this.filteredItems.sort(c),a!=this.sortHistory[0]&&this.sortHistory.unshift(a)}},m.prototype._mode=function(){var a=this.options.layoutMode,b=this.modes[a];if(!b)throw new Error("No layout mode: "+a);return b.options=this.options[a],b},m.prototype._resetLayout=function(){b.prototype._resetLayout.call(this),this._mode()._resetLayout()},m.prototype._getItemLayoutPosition=function(a){return this._mode()._getItemLayoutPosition(a)},m.prototype._manageStamp=function(a){this._mode()._manageStamp(a)},m.prototype._getContainerSize=function(){return this._mode()._getContainerSize()},m.prototype.needsResizeLayout=function(){return this._mode().needsResizeLayout()},m.prototype.appended=function(a){var b=this.addItems(a);if(b.length){var c=this._filterRevealAdded(b);this.filteredItems=this.filteredItems.concat(c)}},m.prototype.prepended=function(a){var b=this._itemize(a);if(b.length){this._resetLayout(),this._manageStamps();var c=this._filterRevealAdded(b);this.layoutItems(this.filteredItems),this.filteredItems=c.concat(this.filteredItems),this.items=b.concat(this.items)}},m.prototype._filterRevealAdded=function(a){var b=this._filter(a);return this.hide(b.needHide),this.reveal(b.matches),this.layoutItems(b.matches,!0),b.matches},m.prototype.insert=function(a){var b=this.addItems(a);if(b.length){var c,d,e=b.length;for(c=0;e>c;c++)d=b[c],this.element.appendChild(d.element);var f=this._filter(b).matches;for(c=0;e>c;c++)b[c].isLayoutInstant=!0;for(this.arrange(),c=0;e>c;c++)delete b[c].isLayoutInstant;this.reveal(f)}};var o=m.prototype.remove;return m.prototype.remove=function(a){a=e.makeArray(a);var b=this.getItems(a);o.call(this,a);var c=b&&b.length;if(c)for(var d=0;c>d;d++){var f=b[d];e.removeFrom(this.filteredItems,f)}},m.prototype.shuffle=function(){for(var a=0,b=this.items.length;b>a;a++){var c=this.items[a];c.sortData.random=Math.random()}this.options.sortBy="random",this._sort(),this._layout()},m.prototype._noTransition=function(a){var b=this.options.transitionDuration;this.options.transitionDuration=0;var c=a.call(this);return this.options.transitionDuration=b,c},m.prototype.getFilteredItemElements=function(){for(var a=[],b=0,c=this.filteredItems.length;c>b;b++)a.push(this.filteredItems[b].element);return a},m});

/*
 * debouncedresize: special jQuery event that happens once after a window resize
 *
 * latest version and complete README available on Github:
 * https://github.com/louisremi/jquery-smartresize
 *
 * Copyright 2012 @louis_remi
 * Licensed under the MIT license.
 *
 * This saved you an hour of work? 
 * Send me music http://www.amazon.co.uk/wishlist/HNTU0468LQON
 */
(function($) {

var $event = $.event,
    $special,
    resizeTimeout;

$special = $event.special.debouncedresize = {
    setup: function() {
        $( this ).on( "resize", $special.handler );
    },
    teardown: function() {
        $( this ).off( "resize", $special.handler );
    },
    handler: function( event, execAsap ) {
        // Save the context
        var context = this,
            args = arguments,
            dispatch = function() {
                // set correct event type
                event.type = "debouncedresize";
                $event.dispatch.apply( context, args );
            };

        if ( resizeTimeout ) {
            clearTimeout( resizeTimeout );
        }

        execAsap ?
            dispatch() :
            resizeTimeout = setTimeout( dispatch, $special.threshold );
    },
    threshold: 150
};

})(jQuery);

// portfolio sorting
(function($) {
    $.fn.stIsotope = function(options)
    {
        return this.each(function()
        {
            var _container       = $(this),
                _parentContainer = _container.parent(),
                _filter          = _parentContainer.find('.portfolio-filters');
            var _options = {
                layoutMode : 'fitRows',
                itemSelector : '.iso-item',
                animationEngine: 'best-available',
                resizable: false,
            };
            if (_container.hasClass("iso-masonry")) {
                _options.layoutMode = 'masonry';
                if ( _container.find(".iso-item:not(.double-width)").length > 0 ) {
                    _options.masonry = { columnWidth: '.iso-item:not(.double-width)' };
                } else {
                    _options.masonry = { columnWidth: '.iso-item' };
                }
            }
            function runIsotope() {
                $("body").css("min-height", $(window).height() + 1);
                var $container = _container.addClass('active').isotope(_options);
                $container.on('arrangeComplete', function(event, laidOutItems) {
                    
                });
                $("body").css("min-height", 0);
                setTimeout(function() { _parentContainer.addClass('isotope-active'); }, 0);
            };

            _filter.on('click', 'a', function() {
                var current     = $(this),
                    selector    = current.data('filter');
                _filter.find(".active").removeClass('active');
                current.addClass('active');

                if (_filter.find(".filter-title").length > 0) {
                    if (typeof current.attr("title") != "undefined" ) {
                        _filter.find(".filter-title").text(current.attr("title"));
                    } else {
                        _filter.find(".filter-title").text(current.text());
                    }
                }

                //_container.css({overflow:'hidden'})
                _options.filter = '.' + selector;
                _container.isotope(_options);
                _container.trigger("filterDone", _options);

                return false;
            });

            $(window).on( 'debouncedresize', function() {
                //runIsotope();
                _container.isotope("layout");
            });

            runIsotope();
        });
    };
})(jQuery);

/* 1. jquery.hoverdir.js v1.1.0 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/**
 * jquery.hoverdir.js v1.1.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2012, Codrops
 * http://www.codrops.com
 */
;( function( $, window, undefined ) {
       
        'use strict';

        $.HoverDir = function( options, element ) {
               
                this.$el = $( element );
                this._init( options );

        };

        // the options
        $.HoverDir.defaults = {
                speed : 300,
                easing : 'ease',
                hoverDelay : 0,
                inverse : false
        };

        $.HoverDir.prototype = {

                _init : function( options ) {
                       
                        // options
                        this.options = $.extend( true, {}, $.HoverDir.defaults, options );
                        // transition properties
                        this.transitionProp = 'all ' + this.options.speed + 'ms ' + this.options.easing;
                        // support for CSS transitions
                        this.support = Modernizr.csstransitions;
                        // load the events
                        this._loadEvents();

                },
                _loadEvents : function() {

                        var self = this;
                       
                        this.$el.on( 'mouseenter.hoverdir, mouseleave.hoverdir', function( event ) {
                               
                                var $el = $( this ),
                                        $hoverElem = $el.find( '.image-extras' ),
                                        direction = self._getDir( $el, { x : event.pageX, y : event.pageY } ),
                                        styleCSS = self._getStyle( direction );
                               
                                if( event.type === 'mouseenter' ) {
                                       
                                        $hoverElem.hide().css( styleCSS.from );
                                        clearTimeout( self.tmhover );

                                        self.tmhover = setTimeout( function() {
                                               
                                                $hoverElem.show( 0, function() {
                                                       
                                                        var $el = $( this );
                                                        if( self.support ) {
                                                                $el.css( 'transition', self.transitionProp );
                                                        }
                                                        self._applyAnimation( $el, styleCSS.to, self.options.speed );

                                                } );
                                               
                                       
                                        }, self.options.hoverDelay );
                                       
                                }
                                else {
                               
                                        if( self.support ) {
                                                $hoverElem.css( 'transition', self.transitionProp );
                                        }
                                        clearTimeout( self.tmhover );
                                        self._applyAnimation( $hoverElem, styleCSS.from, self.options.speed );
                                       
                                }
                                       
                        } );

                },
                // credits : http://stackoverflow.com/a/3647634
                _getDir : function( $el, coordinates ) {
                       
                        // the width and height of the current div
                        var w = $el.width(),
                                h = $el.height(),

                                // calculate the x and y to get an angle to the center of the div from that x and y.
                                // gets the x value relative to the center of the DIV and "normalize" it
                                x = ( coordinates.x - $el.offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ),
                                y = ( coordinates.y - $el.offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ),
                       
                                // the angle and the direction from where the mouse came in/went out clockwise (TRBL=0123);
                                // first calculate the angle of the point,
                                // add 180 deg to get rid of the negative values
                                // divide by 90 to get the quadrant
                                // add 3 and do a modulo by 4  to shift the quadrants to a proper clockwise TRBL (top/right/bottom/left) **/
                                direction = Math.round( ( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3 ) % 4;
                       
                        return direction;
                       
                },
                _getStyle : function( direction ) {
                       
                        var fromStyle, toStyle,
                                slideFromTop = { left : '0px', top : '-100%' },
                                slideFromBottom = { left : '0px', top : '100%' },
                                slideFromLeft = { left : '-100%', top : '0px' },
                                slideFromRight = { left : '100%', top : '0px' },
                                slideTop = { top : '0px' },
                                slideLeft = { left : '0px' };
                       
                        switch( direction ) {
                                case 0:
                                        // from top
                                        fromStyle = !this.options.inverse ? slideFromTop : slideFromBottom;
                                        toStyle = slideTop;
                                        break;
                                case 1:
                                        // from right
                                        fromStyle = !this.options.inverse ? slideFromRight : slideFromLeft;
                                        toStyle = slideLeft;
                                        break;
                                case 2:
                                        // from bottom
                                        fromStyle = !this.options.inverse ? slideFromBottom : slideFromTop;
                                        toStyle = slideTop;
                                        break;
                                case 3:
                                        // from left
                                        fromStyle = !this.options.inverse ? slideFromLeft : slideFromRight;
                                        toStyle = slideLeft;
                                        break;
                        };
                       
                        return { from : fromStyle, to : toStyle };
                                       
                },
                // apply a transition or fallback to jquery animate based on Modernizr.csstransitions support
                _applyAnimation : function( el, styleCSS, speed ) {

                        $.fn.applyStyle = this.support ? $.fn.css : $.fn.animate;
                        el.stop().applyStyle( styleCSS, $.extend( true, [], { duration : speed + 'ms' } ) );

                },

        };
       
        var logError = function( message ) {

                if ( window.console ) {

                        window.console.error( message );
               
                }

        };
       
        $.fn.hoverdir = function( options ) {

                var instance = $.data( this, 'hoverdir' );
               
                if ( typeof options === 'string' ) {
                       
                        var args = Array.prototype.slice.call( arguments, 1 );
                       
                        this.each(function() {
                       
                                if ( !instance ) {

                                        logError( "cannot call methods on hoverdir prior to initialization; " +
                                        "attempted to call method '" + options + "'" );
                                        return;
                               
                                }
                               
                                if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {

                                        logError( "no such method '" + options + "' for hoverdir instance" );
                                        return;
                               
                                }
                               
                                instance[ options ].apply( instance, args );
                       
                        });
               
                }
                else {
               
                        this.each(function() {
                               
                                if ( instance ) {

                                        instance._init();
                               
                                }
                                else {

                                        instance = $.data( this, 'hoverdir', new $.HoverDir( options, this ) );
                               
                                }

                        });
               
                }
               
                return instance;
               
        };
       
} )( jQuery, window );

/*! Magnific Popup - v0.9.9 - 2014-09-06
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2014 Dmitry Semenov; */
(function(e){var t="Close",n="BeforeClose",r="AfterClose",i="BeforeAppend",s="MarkupParse",o="Open",u="Change",a="mfp",f="."+a,l="mfp-ready",c="mfp-removing",h="mfp-prevent-close";var p,d=function(){},v=!!window.jQuery,m,g=e(window),y,b,w,E,S;var x=function(e,t){p.ev.on(a+e+f,t)},T=function(t,n,r,i){var s=document.createElement("div");s.className="mfp-"+t;if(r){s.innerHTML=r}if(!i){s=e(s);if(n){s.appendTo(n)}}else if(n){n.appendChild(s)}return s},N=function(t,n){p.ev.triggerHandler(a+t,n);if(p.st.callbacks){t=t.charAt(0).toLowerCase()+t.slice(1);if(p.st.callbacks[t]){p.st.callbacks[t].apply(p,e.isArray(n)?n:[n])}}},C=function(t){if(t!==S||!p.currTemplate.closeBtn){p.currTemplate.closeBtn=e(p.st.closeMarkup.replace("%title%",p.st.tClose));S=t}return p.currTemplate.closeBtn},k=function(){if(!e.magnificPopup.instance){p=new d;p.init();e.magnificPopup.instance=p}},L=function(){var e=document.createElement("p").style,t=["ms","O","Moz","Webkit"];if(e["transition"]!==undefined){return true}while(t.length){if(t.pop()+"Transition"in e){return true}}return false};d.prototype={constructor:d,init:function(){var t=navigator.appVersion;p.isIE7=t.indexOf("MSIE 7.")!==-1;p.isIE8=t.indexOf("MSIE 8.")!==-1;p.isLowIE=p.isIE7||p.isIE8;p.isAndroid=/android/gi.test(t);p.isIOS=/iphone|ipad|ipod/gi.test(t);p.supportsTransition=L();p.probablyMobile=p.isAndroid||p.isIOS||/(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent);b=e(document);p.popupsCache={}},open:function(t){if(!y){y=e(document.body)}var n;if(t.isObj===false){p.items=t.items.toArray();p.index=0;var r=t.items,i;for(n=0;n<r.length;n++){i=r[n];if(i.parsed){i=i.el[0]}if(i===t.el[0]){p.index=n;break}}}else{p.items=e.isArray(t.items)?t.items:[t.items];p.index=t.index||0}if(p.isOpen){p.updateItemHTML();return}p.types=[];E="";if(t.mainEl&&t.mainEl.length){p.ev=t.mainEl.eq(0)}else{p.ev=b}if(t.key){if(!p.popupsCache[t.key]){p.popupsCache[t.key]={}}p.currTemplate=p.popupsCache[t.key]}else{p.currTemplate={}}p.st=e.extend(true,{},e.magnificPopup.defaults,t);p.fixedContentPos=p.st.fixedContentPos==="auto"?!p.probablyMobile:p.st.fixedContentPos;if(p.st.modal){p.st.closeOnContentClick=false;p.st.closeOnBgClick=false;p.st.showCloseBtn=false;p.st.enableEscapeKey=false}if(!p.bgOverlay){p.bgOverlay=T("bg").on("click"+f,function(){p.close()});p.wrap=T("wrap").attr("tabindex",-1).on("click"+f,function(e){if(p._checkIfClose(e.target)){p.close()}});p.container=T("container",p.wrap)}p.contentContainer=T("content");if(p.st.preloader){p.preloader=T("preloader",p.container,p.st.tLoading)}var u=e.magnificPopup.modules;for(n=0;n<u.length;n++){var a=u[n];a=a.charAt(0).toUpperCase()+a.slice(1);p["init"+a].call(p)}N("BeforeOpen");if(p.st.showCloseBtn){if(!p.st.closeBtnInside){p.wrap.append(C())}else{x(s,function(e,t,n,r){n.close_replaceWith=C(r.type)});E+=" mfp-close-btn-in"}}if(p.st.alignTop){E+=" mfp-align-top"}if(p.fixedContentPos){p.wrap.css({overflow:p.st.overflowY,overflowX:"hidden",overflowY:p.st.overflowY})}else{p.wrap.css({top:g.scrollTop(),position:"absolute"})}if(p.st.fixedBgPos===false||p.st.fixedBgPos==="auto"&&!p.fixedContentPos){p.bgOverlay.css({height:b.height(),position:"absolute"})}if(p.st.enableEscapeKey){b.on("keyup"+f,function(e){if(e.keyCode===27){p.close()}})}g.on("resize"+f,function(){p.updateSize()});if(!p.st.closeOnContentClick){E+=" mfp-auto-cursor"}if(E)p.wrap.addClass(E);var c=p.wH=g.height();var h={};if(p.fixedContentPos){if(p._hasScrollBar(c)){var d=p._getScrollbarSize();if(d){h.marginRight=d}}}if(p.fixedContentPos){if(!p.isIE7){h.overflow="hidden"}else{e("body, html").css("overflow","hidden")}}var v=p.st.mainClass;if(p.isIE7){v+=" mfp-ie7"}if(v){p._addClassToMFP(v)}p.updateItemHTML();N("BuildControls");e("html").css(h);p.bgOverlay.add(p.wrap).prependTo(p.st.prependTo||y);p._lastFocusedEl=document.activeElement;setTimeout(function(){if(p.content){p._addClassToMFP(l);p._setFocus()}else{p.bgOverlay.addClass(l)}b.on("focusin"+f,p._onFocusIn)},16);p.isOpen=true;p.updateSize(c);N(o);return t},close:function(){if(!p.isOpen)return;N(n);p.isOpen=false;if(p.st.removalDelay&&!p.isLowIE&&p.supportsTransition){p._addClassToMFP(c);setTimeout(function(){p._close()},p.st.removalDelay)}else{p._close()}},_close:function(){N(t);var n=c+" "+l+" ";p.bgOverlay.detach();p.wrap.detach();p.container.empty();if(p.st.mainClass){n+=p.st.mainClass+" "}p._removeClassFromMFP(n);if(p.fixedContentPos){var i={marginRight:""};if(p.isIE7){e("body, html").css("overflow","")}else{i.overflow=""}e("html").css(i)}b.off("keyup"+f+" focusin"+f);p.ev.off(f);p.wrap.attr("class","mfp-wrap").removeAttr("style");p.bgOverlay.attr("class","mfp-bg");p.container.attr("class","mfp-container");if(p.st.showCloseBtn&&(!p.st.closeBtnInside||p.currTemplate[p.currItem.type]===true)){if(p.currTemplate.closeBtn)p.currTemplate.closeBtn.detach()}if(p._lastFocusedEl){}p.currItem=null;p.content=null;p.currTemplate=null;p.prevHeight=0;N(r)},updateSize:function(e){if(p.isIOS){var t=document.documentElement.clientWidth/window.innerWidth;var n=window.innerHeight*t;p.wrap.css("height",n);p.wH=n}else{p.wH=e||g.height()}if(!p.fixedContentPos){p.wrap.css("height",p.wH)}N("Resize")},updateItemHTML:function(){var t=p.items[p.index];p.contentContainer.detach();if(p.content)p.content.detach();if(!t.parsed){t=p.parseEl(p.index)}var n=t.type;N("BeforeChange",[p.currItem?p.currItem.type:"",n]);p.currItem=t;if(!p.currTemplate[n]){var r=p.st[n]?p.st[n].markup:false;N("FirstMarkupParse",r);if(r){p.currTemplate[n]=e(r)}else{p.currTemplate[n]=true}}if(w&&w!==t.type){p.container.removeClass("mfp-"+w+"-holder")}var i=p["get"+n.charAt(0).toUpperCase()+n.slice(1)](t,p.currTemplate[n]);p.appendContent(i,n);t.preloaded=true;N(u,t);w=t.type;p.container.prepend(p.contentContainer);N("AfterChange")},appendContent:function(e,t){p.content=e;if(e){if(p.st.showCloseBtn&&p.st.closeBtnInside&&p.currTemplate[t]===true){if(!p.content.find(".mfp-close").length){p.content.append(C())}}else{p.content=e}}else{p.content=""}N(i);p.container.addClass("mfp-"+t+"-holder");p.contentContainer.append(p.content)},parseEl:function(t){var n=p.items[t],r;if(n.tagName){n={el:e(n)}}else{r=n.type;n={data:n,src:n.src}}if(n.el){var i=p.types;for(var s=0;s<i.length;s++){if(n.el.hasClass("mfp-"+i[s])){r=i[s];break}}n.src=n.el.attr("data-mfp-src");if(!n.src){n.src=n.el.attr("href")}}n.type=r||p.st.type||"inline";n.index=t;n.parsed=true;p.items[t]=n;N("ElementParse",n);return p.items[t]},addGroup:function(e,t){var n=function(n){n.mfpEl=this;p._openClick(n,e,t)};if(!t){t={}}var r="click.magnificPopup";t.mainEl=e;if(t.items){t.isObj=true;e.off(r).on(r,n)}else{t.isObj=false;if(t.delegate){e.off(r).on(r,t.delegate,n)}else{t.items=e;e.off(r).on(r,n)}}},_openClick:function(t,n,r){var i=r.midClick!==undefined?r.midClick:e.magnificPopup.defaults.midClick;if(!i&&(t.which===2||t.ctrlKey||t.metaKey)){return}var s=r.disableOn!==undefined?r.disableOn:e.magnificPopup.defaults.disableOn;if(s){if(e.isFunction(s)){if(!s.call(p)){return true}}else{if(g.width()<s){return true}}}if(t.type){t.preventDefault();if(p.isOpen){t.stopPropagation()}}r.el=e(t.mfpEl);if(r.delegate){r.items=n.find(r.delegate)}p.open(r)},updateStatus:function(e,t){if(p.preloader){if(m!==e){p.container.removeClass("mfp-s-"+m)}if(!t&&e==="loading"){t=p.st.tLoading}var n={status:e,text:t};N("UpdateStatus",n);e=n.status;t=n.text;p.preloader.html(t);p.preloader.find("a").on("click",function(e){e.stopImmediatePropagation()});p.container.addClass("mfp-s-"+e);m=e}},_checkIfClose:function(t){if(e(t).hasClass(h)){return}var n=p.st.closeOnContentClick;var r=p.st.closeOnBgClick;if(n&&r){return true}else{if(!p.content||e(t).hasClass("mfp-close")||p.preloader&&t===p.preloader[0]){return true}if(t!==p.content[0]&&!e.contains(p.content[0],t)){if(r){if(e.contains(document,t)){return true}}}else if(n){return true}}return false},_addClassToMFP:function(e){p.bgOverlay.addClass(e);p.wrap.addClass(e)},_removeClassFromMFP:function(e){this.bgOverlay.removeClass(e);p.wrap.removeClass(e)},_hasScrollBar:function(e){return(p.isIE7?b.height():document.body.scrollHeight)>(e||g.height())},_setFocus:function(){(p.st.focus?p.content.find(p.st.focus).eq(0):p.wrap).focus()},_onFocusIn:function(t){if(t.target!==p.wrap[0]&&!e.contains(p.wrap[0],t.target)){p._setFocus();return false}},_parseMarkup:function(t,n,r){var i;if(r.data){n=e.extend(r.data,n)}N(s,[t,n,r]);e.each(n,function(e,n){if(n===undefined||n===false){return true}i=e.split("_");if(i.length>1){var r=t.find(f+"-"+i[0]);if(r.length>0){var s=i[1];if(s==="replaceWith"){if(r[0]!==n[0]){r.replaceWith(n)}}else if(s==="img"){if(r.is("img")){r.attr("src",n)}else{r.replaceWith('<img src="'+n+'" class="'+r.attr("class")+'" />')}}else{r.attr(i[1],n)}}}else{t.find(f+"-"+e).html(n)}})},_getScrollbarSize:function(){if(p.scrollbarSize===undefined){var e=document.createElement("div");e.style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;";document.body.appendChild(e);p.scrollbarSize=e.offsetWidth-e.clientWidth;document.body.removeChild(e)}return p.scrollbarSize}};e.magnificPopup={instance:null,proto:d.prototype,modules:[],open:function(t,n){k();if(!t){t={}}else{t=e.extend(true,{},t)}t.isObj=true;t.index=n||0;return this.instance.open(t)},close:function(){return e.magnificPopup.instance&&e.magnificPopup.instance.close()},registerModule:function(t,n){if(n.options){e.magnificPopup.defaults[t]=n.options}e.extend(this.proto,n.proto);this.modules.push(t)},defaults:{disableOn:0,key:null,midClick:false,mainClass:"",preloader:true,focus:"",closeOnContentClick:false,closeOnBgClick:true,closeBtnInside:true,showCloseBtn:true,enableEscapeKey:true,modal:false,alignTop:false,removalDelay:0,prependTo:null,fixedContentPos:"auto",fixedBgPos:"auto",overflowY:"auto",closeMarkup:'<button title="%title%" type="button" class="mfp-close">&times;</button>',tClose:"Close (Esc)",tLoading:"Loading..."}};e.fn.magnificPopup=function(t){k();var n=e(this);if(typeof t==="string"){if(t==="open"){var r,i=v?n.data("magnificPopup"):n[0].magnificPopup,s=parseInt(arguments[1],10)||0;if(i.items){r=i.items[s]}else{r=n;if(i.delegate){r=r.find(i.delegate)}r=r.eq(s)}p._openClick({mfpEl:r},n,i)}else{if(p.isOpen)p[t].apply(p,Array.prototype.slice.call(arguments,1))}}else{t=e.extend(true,{},t);if(v){n.data("magnificPopup",t)}else{n[0].magnificPopup=t}p.addGroup(n,t)}return n};var A="inline",O,M,_,D=function(){if(_){M.after(_.addClass(O)).detach();_=null}};e.magnificPopup.registerModule(A,{options:{hiddenClass:"hide",markup:"",tNotFound:"Content not found"},proto:{initInline:function(){p.types.push(A);x(t+"."+A,function(){D()})},getInline:function(t,n){D();if(t.src){var r=p.st.inline,i=e(t.src);if(i.length){var s=i[0].parentNode;if(s&&s.tagName){if(!M){O=r.hiddenClass;M=T(O);O="mfp-"+O}_=i.after(M).detach().removeClass(O)}p.updateStatus("ready")}else{p.updateStatus("error",r.tNotFound);i=e("<div>")}t.inlineElement=i;return i}p.updateStatus("ready");p._parseMarkup(n,{},t);return n}}});var P="ajax",H,B=function(){if(H){y.removeClass(H)}},j=function(){B();if(p.req){p.req.abort()}};e.magnificPopup.registerModule(P,{options:{settings:null,cursor:"mfp-ajax-cur",tError:'<a href="%url%">The content</a> could not be loaded.'},proto:{initAjax:function(){p.types.push(P);H=p.st.ajax.cursor;x(t+"."+P,j);x("BeforeChange."+P,j)},getAjax:function(t){if(H)y.addClass(H);p.updateStatus("loading");var n=e.extend({url:t.src,success:function(n,r,i){var s={data:n,xhr:i};N("ParseAjax",s);p.appendContent(e(s.data),P);t.finished=true;B();p._setFocus();setTimeout(function(){p.wrap.addClass(l)},16);p.updateStatus("ready");N("AjaxContentAdded")},error:function(){B();t.finished=t.loadError=true;p.updateStatus("error",p.st.ajax.tError.replace("%url%",t.src))}},p.st.ajax.settings);p.req=e.ajax(n);return""}}});var F,I=function(t){if(t.data&&t.data.title!==undefined)return t.data.title;var n=p.st.image.titleSrc;if(n){if(e.isFunction(n)){return n.call(p,t)}else if(t.el){return t.el.attr(n)||""}}return""};e.magnificPopup.registerModule("image",{options:{markup:'<div class="mfp-figure">'+'<div class="mfp-close"></div>'+"<figure>"+'<div class="mfp-img"></div>'+"<figcaption>"+'<div class="mfp-bottom-bar">'+'<div class="mfp-title"></div>'+'<div class="mfp-counter"></div>'+"</div>"+"</figcaption>"+"</figure>"+"</div>",cursor:"mfp-zoom-out-cur",titleSrc:"title",verticalFit:true,tError:'<a href="%url%">The image</a> could not be loaded.'},proto:{initImage:function(){var e=p.st.image,n=".image";p.types.push("image");x(o+n,function(){if(p.currItem.type==="image"&&e.cursor){y.addClass(e.cursor)}});x(t+n,function(){if(e.cursor){y.removeClass(e.cursor)}g.off("resize"+f)});x("Resize"+n,p.resizeImage);if(p.isLowIE){x("AfterChange",p.resizeImage)}},resizeImage:function(){var e=p.currItem;if(!e||!e.img)return;if(p.st.image.verticalFit){var t=0;if(p.isLowIE){t=parseInt(e.img.css("padding-top"),10)+parseInt(e.img.css("padding-bottom"),10)}e.img.css("max-height",p.wH-t)}},_onImageHasSize:function(e){if(e.img){e.hasSize=true;if(F){clearInterval(F)}e.isCheckingImgSize=false;N("ImageHasSize",e);if(e.imgHidden){if(p.content)p.content.removeClass("mfp-loading");e.imgHidden=false}}},findImageSize:function(e){var t=0,n=e.img[0],r=function(i){if(F){clearInterval(F)}F=setInterval(function(){if(n.naturalWidth>0){p._onImageHasSize(e);return}if(t>200){clearInterval(F)}t++;if(t===3){r(10)}else if(t===40){r(50)}else if(t===100){r(500)}},i)};r(1)},getImage:function(t,n){var r=0,i=function(){if(t){if(t.img[0].complete){t.img.off(".mfploader");if(t===p.currItem){p._onImageHasSize(t);p.updateStatus("ready")}t.hasSize=true;t.loaded=true;N("ImageLoadComplete")}else{r++;if(r<200){setTimeout(i,100)}else{s()}}}},s=function(){if(t){t.img.off(".mfploader");if(t===p.currItem){p._onImageHasSize(t);p.updateStatus("error",o.tError.replace("%url%",t.src))}t.hasSize=true;t.loaded=true;t.loadError=true}},o=p.st.image;var u=n.find(".mfp-img");if(u.length){var a=document.createElement("img");a.className="mfp-img";t.img=e(a).on("load.mfploader",i).on("error.mfploader",s);a.src=t.src;if(u.is("img")){t.img=t.img.clone()}a=t.img[0];if(a.naturalWidth>0){t.hasSize=true}else if(!a.width){t.hasSize=false}}p._parseMarkup(n,{title:I(t),img_replaceWith:t.img},t);p.resizeImage();if(t.hasSize){if(F)clearInterval(F);if(t.loadError){n.addClass("mfp-loading");p.updateStatus("error",o.tError.replace("%url%",t.src))}else{n.removeClass("mfp-loading");p.updateStatus("ready")}return n}p.updateStatus("loading");t.loading=true;if(!t.hasSize){t.imgHidden=true;n.addClass("mfp-loading");p.findImageSize(t)}return n}}});var q,R=function(){if(q===undefined){q=document.createElement("p").style.MozTransform!==undefined}return q};e.magnificPopup.registerModule("zoom",{options:{enabled:false,easing:"ease-in-out",duration:300,opener:function(e){return e.is("img")?e:e.find("img")}},proto:{initZoom:function(){var e=p.st.zoom,r=".zoom",i;if(!e.enabled||!p.supportsTransition){return}var s=e.duration,o=function(t){var n=t.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),r="all "+e.duration/1e3+"s "+e.easing,i={position:"fixed",zIndex:9999,left:0,top:0,"-webkit-backface-visibility":"hidden"},s="transition";i["-webkit-"+s]=i["-moz-"+s]=i["-o-"+s]=i[s]=r;n.css(i);return n},u=function(){p.content.css("visibility","visible")},a,f;x("BuildControls"+r,function(){if(p._allowZoom()){clearTimeout(a);p.content.css("visibility","hidden");i=p._getItemToZoom();if(!i){u();return}f=o(i);f.css(p._getOffset());p.wrap.append(f);a=setTimeout(function(){f.css(p._getOffset(true));a=setTimeout(function(){u();setTimeout(function(){f.remove();i=f=null;N("ZoomAnimationEnded")},16)},s)},16)}});x(n+r,function(){if(p._allowZoom()){clearTimeout(a);p.st.removalDelay=s;if(!i){i=p._getItemToZoom();if(!i){return}f=o(i)}f.css(p._getOffset(true));p.wrap.append(f);p.content.css("visibility","hidden");setTimeout(function(){f.css(p._getOffset())},16)}});x(t+r,function(){if(p._allowZoom()){u();if(f){f.remove()}i=null}})},_allowZoom:function(){return p.currItem.type==="image"},_getItemToZoom:function(){if(p.currItem.hasSize){return p.currItem.img}else{return false}},_getOffset:function(t){var n;if(t){n=p.currItem.img}else{n=p.st.zoom.opener(p.currItem.el||p.currItem)}var r=n.offset();var i=parseInt(n.css("padding-top"),10);var s=parseInt(n.css("padding-bottom"),10);r.top-=e(window).scrollTop()-i;var o={width:n.width(),height:(v?n.innerHeight():n[0].offsetHeight)-s-i};if(R()){o["-moz-transform"]=o["transform"]="translate("+r.left+"px,"+r.top+"px)"}else{o.left=r.left;o.top=r.top}return o}}});var U="iframe",z="//about:blank",W=function(e){if(p.currTemplate[U]){var t=p.currTemplate[U].find("iframe");if(t.length){if(!e){t[0].src=z}if(p.isIE8){t.css("display",e?"block":"none")}}}};e.magnificPopup.registerModule(U,{options:{markup:'<div class="mfp-iframe-scaler">'+'<div class="mfp-close"></div>'+'<iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe>'+"</div>",srcAction:"iframe_src",patterns:{youtube:{index:"youtube.com",id:"v=",src:"//www.youtube.com/embed/%id%?autoplay=1"},vimeo:{index:"vimeo.com/",id:"/",src:"//player.vimeo.com/video/%id%?autoplay=1"},gmaps:{index:"//maps.google.",src:"%id%&output=embed"}}},proto:{initIframe:function(){p.types.push(U);x("BeforeChange",function(e,t,n){if(t!==n){if(t===U){W()}else if(n===U){W(true)}}});x(t+"."+U,function(){W()})},getIframe:function(t,n){var r=t.src;var i=p.st.iframe;e.each(i.patterns,function(){if(r.indexOf(this.index)>-1){if(this.id){if(typeof this.id==="string"){r=r.substr(r.lastIndexOf(this.id)+this.id.length,r.length)}else{r=this.id.call(this,r)}}r=this.src.replace("%id%",r);return false}});var s={};if(i.srcAction){s[i.srcAction]=r}p._parseMarkup(n,s,t);p.updateStatus("ready");return n}}});var X=function(e){var t=p.items.length;if(e>t-1){return e-t}else if(e<0){return t+e}return e},V=function(e,t,n){return e.replace(/%curr%/gi,t+1).replace(/%total%/gi,n)};e.magnificPopup.registerModule("gallery",{options:{enabled:false,arrowMarkup:'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',preload:[0,2],navigateByImgClick:true,arrows:true,tPrev:"Previous (Left arrow key)",tNext:"Next (Right arrow key)",tCounter:"%curr% of %total%"},proto:{initGallery:function(){var n=p.st.gallery,r=".mfp-gallery",i=Boolean(e.fn.mfpFastClick);p.direction=true;if(!n||!n.enabled)return false;E+=" mfp-gallery";x(o+r,function(){if(n.navigateByImgClick){p.wrap.on("click"+r,".mfp-img",function(){if(p.items.length>1){p.next();return false}})}b.on("keydown"+r,function(e){if(e.keyCode===37){p.prev()}else if(e.keyCode===39){p.next()}})});x("UpdateStatus"+r,function(e,t){if(t.text){t.text=V(t.text,p.currItem.index,p.items.length)}});x(s+r,function(e,t,r,i){var s=p.items.length;r.counter=s>1?V(n.tCounter,i.index,s):""});x("BuildControls"+r,function(){if(p.items.length>1&&n.arrows&&!p.arrowLeft){var t=n.arrowMarkup,r=p.arrowLeft=e(t.replace(/%title%/gi,n.tPrev).replace(/%dir%/gi,"left")).addClass(h),s=p.arrowRight=e(t.replace(/%title%/gi,n.tNext).replace(/%dir%/gi,"right")).addClass(h);var o=i?"mfpFastClick":"click";r[o](function(){p.prev()});s[o](function(){p.next()});if(p.isIE7){T("b",r[0],false,true);T("a",r[0],false,true);T("b",s[0],false,true);T("a",s[0],false,true)}p.container.append(r.add(s))}});x(u+r,function(){if(p._preloadTimeout)clearTimeout(p._preloadTimeout);p._preloadTimeout=setTimeout(function(){p.preloadNearbyImages();p._preloadTimeout=null},16)});x(t+r,function(){b.off(r);p.wrap.off("click"+r);if(p.arrowLeft&&i){p.arrowLeft.add(p.arrowRight).destroyMfpFastClick()}p.arrowRight=p.arrowLeft=null})},next:function(){p.direction=true;p.index=X(p.index+1);p.updateItemHTML()},prev:function(){p.direction=false;p.index=X(p.index-1);p.updateItemHTML()},goTo:function(e){p.direction=e>=p.index;p.index=e;p.updateItemHTML()},preloadNearbyImages:function(){var e=p.st.gallery.preload,t=Math.min(e[0],p.items.length),n=Math.min(e[1],p.items.length),r;for(r=1;r<=(p.direction?n:t);r++){p._preloadItem(p.index+r)}for(r=1;r<=(p.direction?t:n);r++){p._preloadItem(p.index-r)}},_preloadItem:function(t){t=X(t);if(p.items[t].preloaded){return}var n=p.items[t];if(!n.parsed){n=p.parseEl(t)}N("LazyLoad",n);if(n.type==="image"){n.img=e('<img class="mfp-img" />').on("load.mfploader",function(){n.hasSize=true}).on("error.mfploader",function(){n.hasSize=true;n.loadError=true;N("LazyLoadError",n)}).attr("src",n.src)}n.preloaded=true}}});var $="retina";e.magnificPopup.registerModule($,{options:{replaceSrc:function(e){return e.src.replace(/\.\w+$/,function(e){return"@2x"+e})},ratio:1},proto:{initRetina:function(){if(window.devicePixelRatio>1){var e=p.st.retina,t=e.ratio;t=!isNaN(t)?t:t();if(t>1){x("ImageHasSize"+"."+$,function(e,n){n.img.css({"max-width":n.img[0].naturalWidth/t,width:"100%"})});x("ElementParse"+"."+$,function(n,r){r.src=e.replaceSrc(r,t)})}}}}});(function(){var t=1e3,n="ontouchstart"in window,r=function(){g.off("touchmove"+s+" touchend"+s)},i="mfpFastClick",s="."+i;e.fn.mfpFastClick=function(i){return e(this).each(function(){var o=e(this),u;if(n){var a,f,l,c,h,p;o.on("touchstart"+s,function(e){c=false;p=1;h=e.originalEvent?e.originalEvent.touches[0]:e.touches[0];f=h.clientX;l=h.clientY;g.on("touchmove"+s,function(e){h=e.originalEvent?e.originalEvent.touches:e.touches;p=h.length;h=h[0];if(Math.abs(h.clientX-f)>10||Math.abs(h.clientY-l)>10){c=true;r()}}).on("touchend"+s,function(e){r();if(c||p>1){return}u=true;e.preventDefault();clearTimeout(a);a=setTimeout(function(){u=false},t);i()})})}o.on("click"+s,function(){if(!u){i()}})})};e.fn.destroyMfpFastClick=function(){e(this).off("touchstart"+s+" click"+s);if(n)g.off("touchmove"+s+" touchend"+s)}})();k()})(window.jQuery||window.Zepto);


/*jshint browser:true */
/*!
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

;(function( $ ){

  'use strict';

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null,
      ignore: null
    };

    if(!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement("div");
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        'iframe[src*="player.vimeo.com"]',
        'iframe[src*="youtube.com"]',
        'iframe[src*="youtube-nocookie.com"]',
        'iframe[src*="kickstarter.com"][src*="video.html"]',
        'object',
        'embed'
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var ignoreList = '.fitvidsignore';

      if(settings.ignore) {
        ignoreList = ignoreList + ', ' + settings.ignore;
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not('object object'); // SwfObj conflict patch
      $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

      $allVideos.each(function(count){
        var $this = $(this);
        if($this.parents(ignoreList).length > 0) {
          return; // Disable FitVids on this video.
        }
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
        {
          $this.attr('height', 9);
          $this.attr('width', 16);
        }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('id')){
          var videoID = 'fitvid' + count;
          $this.attr('id', videoID);
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );

/*! Stellar.js v0.6.2 | Copyright 2014, Mark Dalgleish | http://markdalgleish.com/projects/stellar.js | http://markdalgleish.mit-license.org */
!function(a,b,c,d){function e(b,c){this.element=b,this.options=a.extend({},g,c),this._defaults=g,this._name=f,this.init()}var f="stellar",g={scrollProperty:"scroll",positionProperty:"position",horizontalScrolling:!0,verticalScrolling:!0,horizontalOffset:0,verticalOffset:0,responsive:!1,parallaxBackgrounds:!0,parallaxElements:!0,hideDistantElements:!0,hideElement:function(a){a.hide()},showElement:function(a){a.show()}},h={scroll:{getLeft:function(a){return a.scrollLeft()},setLeft:function(a,b){a.scrollLeft(b)},getTop:function(a){return a.scrollTop()},setTop:function(a,b){a.scrollTop(b)}},position:{getLeft:function(a){return-1*parseInt(a.css("left"),10)},getTop:function(a){return-1*parseInt(a.css("top"),10)}},margin:{getLeft:function(a){return-1*parseInt(a.css("margin-left"),10)},getTop:function(a){return-1*parseInt(a.css("margin-top"),10)}},transform:{getLeft:function(a){var b=getComputedStyle(a[0])[k];return"none"!==b?-1*parseInt(b.match(/(-?[0-9]+)/g)[4],10):0},getTop:function(a){var b=getComputedStyle(a[0])[k];return"none"!==b?-1*parseInt(b.match(/(-?[0-9]+)/g)[5],10):0}}},i={position:{setLeft:function(a,b){a.css("left",b)},setTop:function(a,b){a.css("top",b)}},transform:{setPosition:function(a,b,c,d,e){a[0].style[k]="translate3d("+(b-c)+"px, "+(d-e)+"px, 0)"}}},j=function(){var b,c=/^(Moz|Webkit|Khtml|O|ms|Icab)(?=[A-Z])/,d=a("script")[0].style,e="";for(b in d)if(c.test(b)){e=b.match(c)[0];break}return"WebkitOpacity"in d&&(e="Webkit"),"KhtmlOpacity"in d&&(e="Khtml"),function(a){return e+(e.length>0?a.charAt(0).toUpperCase()+a.slice(1):a)}}(),k=j("transform"),l=a("<div />",{style:"background:#fff"}).css("background-position-x")!==d,m=l?function(a,b,c){a.css({"background-position-x":b,"background-position-y":c})}:function(a,b,c){a.css("background-position",b+" "+c)},n=l?function(a){return[a.css("background-position-x"),a.css("background-position-y")]}:function(a){return a.css("background-position").split(" ")},o=b.requestAnimationFrame||b.webkitRequestAnimationFrame||b.mozRequestAnimationFrame||b.oRequestAnimationFrame||b.msRequestAnimationFrame||function(a){setTimeout(a,1e3/60)};e.prototype={init:function(){this.options.name=f+"_"+Math.floor(1e9*Math.random()),this._defineElements(),this._defineGetters(),this._defineSetters(),this._handleWindowLoadAndResize(),this._detectViewport(),this.refresh({firstLoad:!0}),"scroll"===this.options.scrollProperty?this._handleScrollEvent():this._startAnimationLoop()},_defineElements:function(){this.element===c.body&&(this.element=b),this.$scrollElement=a(this.element),this.$element=this.element===b?a("body"):this.$scrollElement,this.$viewportElement=this.options.viewportElement!==d?a(this.options.viewportElement):this.$scrollElement[0]===b||"scroll"===this.options.scrollProperty?this.$scrollElement:this.$scrollElement.parent()},_defineGetters:function(){var a=this,b=h[a.options.scrollProperty];this._getScrollLeft=function(){return b.getLeft(a.$scrollElement)},this._getScrollTop=function(){return b.getTop(a.$scrollElement)}},_defineSetters:function(){var b=this,c=h[b.options.scrollProperty],d=i[b.options.positionProperty],e=c.setLeft,f=c.setTop;this._setScrollLeft="function"==typeof e?function(a){e(b.$scrollElement,a)}:a.noop,this._setScrollTop="function"==typeof f?function(a){f(b.$scrollElement,a)}:a.noop,this._setPosition=d.setPosition||function(a,c,e,f,g){b.options.horizontalScrolling&&d.setLeft(a,c,e),b.options.verticalScrolling&&d.setTop(a,f,g)}},_handleWindowLoadAndResize:function(){var c=this,d=a(b);c.options.responsive&&d.bind("load."+this.name,function(){c.refresh()}),d.bind("resize."+this.name,function(){c._detectViewport(),c.options.responsive&&c.refresh()})},refresh:function(c){var d=this,e=d._getScrollLeft(),f=d._getScrollTop();c&&c.firstLoad||this._reset(),this._setScrollLeft(0),this._setScrollTop(0),this._setOffsets(),this._findParticles(),this._findBackgrounds(),c&&c.firstLoad&&/WebKit/.test(navigator.userAgent)&&a(b).load(function(){var a=d._getScrollLeft(),b=d._getScrollTop();d._setScrollLeft(a+1),d._setScrollTop(b+1),d._setScrollLeft(a),d._setScrollTop(b)}),this._setScrollLeft(e),this._setScrollTop(f)},_detectViewport:function(){var a=this.$viewportElement.offset(),b=null!==a&&a!==d;this.viewportWidth=this.$viewportElement.width(),this.viewportHeight=this.$viewportElement.height(),this.viewportOffsetTop=b?a.top:0,this.viewportOffsetLeft=b?a.left:0},_findParticles:function(){{var b=this;this._getScrollLeft(),this._getScrollTop()}if(this.particles!==d)for(var c=this.particles.length-1;c>=0;c--)this.particles[c].$element.data("stellar-elementIsActive",d);this.particles=[],this.options.parallaxElements&&this.$element.find("[data-stellar-ratio]").each(function(){var c,e,f,g,h,i,j,k,l,m=a(this),n=0,o=0,p=0,q=0;if(m.data("stellar-elementIsActive")){if(m.data("stellar-elementIsActive")!==this)return}else m.data("stellar-elementIsActive",this);b.options.showElement(m),m.data("stellar-startingLeft")?(m.css("left",m.data("stellar-startingLeft")),m.css("top",m.data("stellar-startingTop"))):(m.data("stellar-startingLeft",m.css("left")),m.data("stellar-startingTop",m.css("top"))),f=m.position().left,g=m.position().top,h="auto"===m.css("margin-left")?0:parseInt(m.css("margin-left"),10),i="auto"===m.css("margin-top")?0:parseInt(m.css("margin-top"),10),k=m.offset().left-h,l=m.offset().top-i,m.parents().each(function(){var b=a(this);return b.data("stellar-offset-parent")===!0?(n=p,o=q,j=b,!1):(p+=b.position().left,void(q+=b.position().top))}),c=m.data("stellar-horizontal-offset")!==d?m.data("stellar-horizontal-offset"):j!==d&&j.data("stellar-horizontal-offset")!==d?j.data("stellar-horizontal-offset"):b.horizontalOffset,e=m.data("stellar-vertical-offset")!==d?m.data("stellar-vertical-offset"):j!==d&&j.data("stellar-vertical-offset")!==d?j.data("stellar-vertical-offset"):b.verticalOffset,b.particles.push({$element:m,$offsetParent:j,isFixed:"fixed"===m.css("position"),horizontalOffset:c,verticalOffset:e,startingPositionLeft:f,startingPositionTop:g,startingOffsetLeft:k,startingOffsetTop:l,parentOffsetLeft:n,parentOffsetTop:o,stellarRatio:m.data("stellar-ratio")!==d?m.data("stellar-ratio"):1,width:m.outerWidth(!0),height:m.outerHeight(!0),isHidden:!1})})},_findBackgrounds:function(){var b,c=this,e=this._getScrollLeft(),f=this._getScrollTop();this.backgrounds=[],this.options.parallaxBackgrounds&&(b=this.$element.find("[data-stellar-background-ratio]"),this.$element.data("stellar-background-ratio")&&(b=b.add(this.$element)),b.each(function(){var b,g,h,i,j,k,l,o=a(this),p=n(o),q=0,r=0,s=0,t=0;if(o.data("stellar-backgroundIsActive")){if(o.data("stellar-backgroundIsActive")!==this)return}else o.data("stellar-backgroundIsActive",this);o.data("stellar-backgroundStartingLeft")?m(o,o.data("stellar-backgroundStartingLeft"),o.data("stellar-backgroundStartingTop")):(o.data("stellar-backgroundStartingLeft",p[0]),o.data("stellar-backgroundStartingTop",p[1])),h="auto"===o.css("margin-left")?0:parseInt(o.css("margin-left"),10),i="auto"===o.css("margin-top")?0:parseInt(o.css("margin-top"),10),j=o.offset().left-h-e,k=o.offset().top-i-f,o.parents().each(function(){var b=a(this);return b.data("stellar-offset-parent")===!0?(q=s,r=t,l=b,!1):(s+=b.position().left,void(t+=b.position().top))}),b=o.data("stellar-horizontal-offset")!==d?o.data("stellar-horizontal-offset"):l!==d&&l.data("stellar-horizontal-offset")!==d?l.data("stellar-horizontal-offset"):c.horizontalOffset,g=o.data("stellar-vertical-offset")!==d?o.data("stellar-vertical-offset"):l!==d&&l.data("stellar-vertical-offset")!==d?l.data("stellar-vertical-offset"):c.verticalOffset,c.backgrounds.push({$element:o,$offsetParent:l,isFixed:"fixed"===o.css("background-attachment"),horizontalOffset:b,verticalOffset:g,startingValueLeft:p[0],startingValueTop:p[1],startingBackgroundPositionLeft:isNaN(parseInt(p[0],10))?0:parseInt(p[0],10),startingBackgroundPositionTop:isNaN(parseInt(p[1],10))?0:parseInt(p[1],10),startingPositionLeft:o.position().left,startingPositionTop:o.position().top,startingOffsetLeft:j,startingOffsetTop:k,parentOffsetLeft:q,parentOffsetTop:r,stellarRatio:o.data("stellar-background-ratio")===d?1:o.data("stellar-background-ratio")})}))},_reset:function(){var a,b,c,d,e;for(e=this.particles.length-1;e>=0;e--)a=this.particles[e],b=a.$element.data("stellar-startingLeft"),c=a.$element.data("stellar-startingTop"),this._setPosition(a.$element,b,b,c,c),this.options.showElement(a.$element),a.$element.data("stellar-startingLeft",null).data("stellar-elementIsActive",null).data("stellar-backgroundIsActive",null);for(e=this.backgrounds.length-1;e>=0;e--)d=this.backgrounds[e],d.$element.data("stellar-backgroundStartingLeft",null).data("stellar-backgroundStartingTop",null),m(d.$element,d.startingValueLeft,d.startingValueTop)},destroy:function(){this._reset(),this.$scrollElement.unbind("resize."+this.name).unbind("scroll."+this.name),this._animationLoop=a.noop,a(b).unbind("load."+this.name).unbind("resize."+this.name)},_setOffsets:function(){var c=this,d=a(b);d.unbind("resize.horizontal-"+this.name).unbind("resize.vertical-"+this.name),"function"==typeof this.options.horizontalOffset?(this.horizontalOffset=this.options.horizontalOffset(),d.bind("resize.horizontal-"+this.name,function(){c.horizontalOffset=c.options.horizontalOffset()})):this.horizontalOffset=this.options.horizontalOffset,"function"==typeof this.options.verticalOffset?(this.verticalOffset=this.options.verticalOffset(),d.bind("resize.vertical-"+this.name,function(){c.verticalOffset=c.options.verticalOffset()})):this.verticalOffset=this.options.verticalOffset},_repositionElements:function(){var a,b,c,d,e,f,g,h,i,j,k=this._getScrollLeft(),l=this._getScrollTop(),n=!0,o=!0;if(this.currentScrollLeft!==k||this.currentScrollTop!==l||this.currentWidth!==this.viewportWidth||this.currentHeight!==this.viewportHeight){for(this.currentScrollLeft=k,this.currentScrollTop=l,this.currentWidth=this.viewportWidth,this.currentHeight=this.viewportHeight,j=this.particles.length-1;j>=0;j--)a=this.particles[j],b=a.isFixed?1:0,this.options.horizontalScrolling?(f=(k+a.horizontalOffset+this.viewportOffsetLeft+a.startingPositionLeft-a.startingOffsetLeft+a.parentOffsetLeft)*-(a.stellarRatio+b-1)+a.startingPositionLeft,h=f-a.startingPositionLeft+a.startingOffsetLeft):(f=a.startingPositionLeft,h=a.startingOffsetLeft),this.options.verticalScrolling?(g=(l+a.verticalOffset+this.viewportOffsetTop+a.startingPositionTop-a.startingOffsetTop+a.parentOffsetTop)*-(a.stellarRatio+b-1)+a.startingPositionTop,i=g-a.startingPositionTop+a.startingOffsetTop):(g=a.startingPositionTop,i=a.startingOffsetTop),this.options.hideDistantElements&&(o=!this.options.horizontalScrolling||h+a.width>(a.isFixed?0:k)&&h<(a.isFixed?0:k)+this.viewportWidth+this.viewportOffsetLeft,n=!this.options.verticalScrolling||i+a.height>(a.isFixed?0:l)&&i<(a.isFixed?0:l)+this.viewportHeight+this.viewportOffsetTop),o&&n?(a.isHidden&&(this.options.showElement(a.$element),a.isHidden=!1),this._setPosition(a.$element,f,a.startingPositionLeft,g,a.startingPositionTop)):a.isHidden||(this.options.hideElement(a.$element),a.isHidden=!0);for(j=this.backgrounds.length-1;j>=0;j--)c=this.backgrounds[j],b=c.isFixed?0:1,d=this.options.horizontalScrolling?(k+c.horizontalOffset-this.viewportOffsetLeft-c.startingOffsetLeft+c.parentOffsetLeft-c.startingBackgroundPositionLeft)*(b-c.stellarRatio)+"px":c.startingValueLeft,e=this.options.verticalScrolling?(l+c.verticalOffset-this.viewportOffsetTop-c.startingOffsetTop+c.parentOffsetTop-c.startingBackgroundPositionTop)*(b-c.stellarRatio)+"px":c.startingValueTop,m(c.$element,d,e)}},_handleScrollEvent:function(){var a=this,b=!1,c=function(){a._repositionElements(),b=!1},d=function(){b||(o(c),b=!0)};this.$scrollElement.bind("scroll."+this.name,d),d()},_startAnimationLoop:function(){var a=this;this._animationLoop=function(){o(a._animationLoop),a._repositionElements()},this._animationLoop()}},a.fn[f]=function(b){var c=arguments;return b===d||"object"==typeof b?this.each(function(){a.data(this,"plugin_"+f)||a.data(this,"plugin_"+f,new e(this,b))}):"string"==typeof b&&"_"!==b[0]&&"init"!==b?this.each(function(){var d=a.data(this,"plugin_"+f);d instanceof e&&"function"==typeof d[b]&&d[b].apply(d,Array.prototype.slice.call(c,1)),"destroy"===b&&a.data(this,"plugin_"+f,null)}):void 0},a[f]=function(){var c=a(b);return c.stellar.apply(c,Array.prototype.slice.call(arguments,0))},a[f].scrollProperty=h,a[f].positionProperty=i,b.Stellar=e}(jQuery,this,document);


/* 9. jQuery easyZoom plugin ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
(function ($) {

    'use strict';

    var dw, dh, rw, rh, lx, ly;

    var defaults = {

        // The text to display within the notice box while loading the zoom image.
        loadingNotice: 'Loading image',

        // The text to display within the notice box if an error occurs loading the zoom image.
        errorNotice: 'The image could not be loaded',

        // The time (in milliseconds) to display the error notice.
        errorDuration: 2500,

        // Prevent clicks on the zoom image link.
        preventClicks: true,

        // Callback function to execute when the flyout is displayed.
        onShow: undefined,

        // Callback function to execute when the flyout is removed.
        onHide: undefined

    };

    /**
     * EasyZoom
     * @constructor
     * @param {Object} target
     * @param {Object} options
     */
    function EasyZoom(target, options) {
        this.$target = $(target);
        this.opts = $.extend({}, defaults, options);

        if (this.isOpen === undefined) {
            this._init();
        }

        return this;
    }

    /**
     * Init
     * @private
     */
    EasyZoom.prototype._init = function() {
        var self = this;

        this.$link   = this.$target.find('a');
        this.$image  = this.$target.find('img');

        this.$flyout = $('<div class="easyzoom-flyout" />');
        this.$notice = $('<div class="easyzoom-notice" />');

        this.$target
            .on('mouseenter.easyzoom touchstart.easyzoom', function(e) {
                self.isMouseOver = true;

                if (!e.originalEvent.touches || e.originalEvent.touches.length === 1) {
                    e.preventDefault();
                    self.show(e, true);
                }
            })
            .on('mousemove.easyzoom touchmove.easyzoom', function(e) {
                if (self.isOpen) {
                    e.preventDefault();
                    self._move(e);
                }
            })
            .on('mouseleave.easyzoom touchend.easyzoom', function() {
                self.isMouseOver = false;

                if (self.isOpen) {
                    self.hide();
                }
            });

        if (this.opts.preventClicks) {
            this.$target.on('click.easyzoom', 'a', function(e) {
                e.preventDefault();
            });
        }
    };

    /**
     * Show
     * @param {MouseEvent|TouchEvent} e
     * @param {Boolean} testMouseOver
     */
    EasyZoom.prototype.show = function(e, testMouseOver) {
        var w1, h1, w2, h2;
        var self = this;

        if (! this.isReady) {
            this._load(this.$link.attr('href'), function() {
                if (self.isMouseOver || !testMouseOver) {
                    self.show(e);
                }
            });

            return;
        }

        this.$target.append(this.$flyout);

        w1 = this.$target.width();
        h1 = this.$target.height();

        w2 = this.$flyout.width();
        h2 = this.$flyout.height();

        dw = this.$zoom.width() - w2;
        dh = this.$zoom.height() - h2;

        rw = dw / w1;
        rh = dh / h1;

        this.isOpen = true;

        if (this.opts.onShow) {
            this.opts.onShow.call(this);
        }

        if (e) {
            this._move(e);
        }
    };

    /**
     * Load
     * @private
     * @param {String} href
     * @param {Function} callback
     */
    EasyZoom.prototype._load = function(href, callback) {
        var zoom = new Image();

        this.$target.addClass('is-loading').append(this.$notice.text(this.opts.loadingNotice));

        this.$zoom = $(zoom);

        zoom.onerror = $.proxy(function() {
            var self = this;

            this.$notice.text(this.opts.errorNotice);
            this.$target.removeClass('is-loading').addClass('is-error');

            this.detachNotice = setTimeout(function() {
                self.$notice.detach();
                self.detachNotice = null;
            }, this.opts.errorDuration);
        }, this);

        zoom.onload = $.proxy(function() {

            // IE may fire a load event even on error so check the image has dimensions
            if (!zoom.width) {
                return;
            }

            this.isReady = true;

            this.$notice.detach();
            this.$flyout.html(this.$zoom);
            this.$target.removeClass('is-loading').addClass('is-ready');

            callback();
        }, this);

        zoom.style.position = 'absolute';
        zoom.src = href;
    };

    /**
     * Move
     * @private
     * @param {Event} e
     */
    EasyZoom.prototype._move = function(e) {

        if (e.type.indexOf('touch') === 0) {
            var touchlist = e.touches || e.originalEvent.touches;
            lx = touchlist[0].pageX;
            ly = touchlist[0].pageY;
        }
        else {
            lx = e.pageX || lx;
            ly = e.pageY || ly;
        }

        var offset  = this.$target.offset();
        var pt = ly - offset.top;
        var pl = lx - offset.left;
        var xt = Math.ceil(pt * rh);
        var xl = Math.ceil(pl * rw);

        // Close if outside
        if (xl < 0 || xt < 0 || xl > dw || xt > dh) {
            this.hide();
        }
        else {
            this.$zoom.css({
                top:  '' + (xt * -1) + 'px',
                left: '' + (xl * -1) + 'px'
            });
        }

    };

    /**
     * Hide
     */
    EasyZoom.prototype.hide = function() {
        if (this.isOpen) {
            this.$flyout.detach();
            this.isOpen = false;

            if (this.opts.onHide) {
                this.opts.onHide.call(this);
            }
        }
    };

    /**
     * Swap
     * @param {String} standardSrc
     * @param {String} zoomHref
     * @param {String|Array} srcsetStringOrArray (Optional)
     */
    EasyZoom.prototype.swap = function(standardSrc, zoomHref, srcsetStringOrArray) {
        this.hide();
        this.isReady = false;

        if (this.detachNotice) {
            clearTimeout(this.detachNotice);
        }

        if (this.$notice.parent().length) {
            this.$notice.detach();
        }

        if ($.isArray(srcsetStringOrArray)) {
            srcsetStringOrArray = srcsetStringOrArray.join();
        }

        this.$target.removeClass('is-loading is-ready is-error');
        this.$image.attr({
            src: standardSrc,
            srcset: srcsetStringOrArray
        });
        this.$link.attr('href', zoomHref);
    };

    /**
     * Teardown
     */
    EasyZoom.prototype.teardown = function() {
        this.hide();

        this.$target.removeClass('is-loading is-ready is-error').off('.easyzoom');

        if (this.detachNotice) {
            clearTimeout(this.detachNotice);
        }

        delete this.$link;
        delete this.$zoom;
        delete this.$image;
        delete this.$notice;
        delete this.$flyout;

        delete this.isOpen;
        delete this.isReady;
    };

    // jQuery plugin wrapper
    $.fn.easyZoom = function(options) {
        return this.each(function() {
            var api = $.data(this, 'easyZoom');

            if (!api) {
                $.data(this, 'easyZoom', new EasyZoom(this, options));
            }
            else if (api.isOpen === undefined) {
                api._init();
            }
        });
    };

    // AMD and CommonJS module compatibility
    if (typeof define === 'function' && define.amd){
        define(function() {
            return EasyZoom;
        });
    }
    else if (typeof module !== 'undefined' && module.exports) {
        module.exports = EasyZoom;
    }

})(jQuery);


/* jQuery CounTo plugin ~~~~~~~~~~~~~~~~~~~~~~~ */
(function(a){a.fn.countTo=function(g){g=g||{};return a(this).each(function(){function e(a){a=b.formatter.call(h,a,b);f.html(a)}var b=a.extend({},a.fn.countTo.defaults,{from:a(this).data("from"),to:a(this).data("to"),speed:a(this).data("speed"),refreshInterval:a(this).data("refresh-interval"),decimals:a(this).data("decimals")},g),j=Math.ceil(b.speed/b.refreshInterval),l=(b.to-b.from)/j,h=this,f=a(this),k=0,c=b.from,d=f.data("countTo")||{};f.data("countTo",d);d.interval&&clearInterval(d.interval);d.interval=
setInterval(function(){c+=l;k++;e(c);"function"==typeof b.onUpdate&&b.onUpdate.call(h,c);k>=j&&(f.removeData("countTo"),clearInterval(d.interval),c=b.to,"function"==typeof b.onComplete&&b.onComplete.call(h,c))},b.refreshInterval);e(c)})};a.fn.countTo.defaults={from:0,to:0,speed:1E3,refreshInterval:100,decimals:0,formatter:function(a,e){return a.toFixed(e.decimals)},onUpdate:null,onComplete:null}})(jQuery);

/* 8. image loaded plugin ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
(function(c,q){var m="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";c.fn.imagesLoaded=function(f){function n(){var b=c(j),a=c(h);d&&(h.length?d.reject(e,b,a):d.resolve(e));c.isFunction(f)&&f.call(g,e,b,a)}function p(b){k(b.target,"error"===b.type)}function k(b,a){b.src===m||-1!==c.inArray(b,l)||(l.push(b),a?h.push(b):j.push(b),c.data(b,"imagesLoaded",{isBroken:a,src:b.src}),r&&d.notifyWith(c(b),[a,e,c(j),c(h)]),e.length===l.length&&(setTimeout(n),e.unbind(".imagesLoaded",
p)))}var g=this,d=c.isFunction(c.Deferred)?c.Deferred():0,r=c.isFunction(d.notify),e=g.find("img").add(g.filter("img")),l=[],j=[],h=[];c.isPlainObject(f)&&c.each(f,function(b,a){if("callback"===b)f=a;else if(d)d[b](a)});e.length?e.bind("load.imagesLoaded error.imagesLoaded",p).each(function(b,a){var d=a.src,e=c.data(a,"imagesLoaded");if(e&&e.src===d)k(a,e.isBroken);else if(a.complete&&a.naturalWidth!==q)k(a,0===a.naturalWidth||0===a.naturalHeight);else if(a.readyState||a.complete)a.src=m,a.src=d}):
n();return d?d.promise(g):g}})(jQuery);

/**
 * jquery.nicescroll 3.5.4
 * InuYaksa 2013 MIT http://areaaperta.com/nicescroll
 * */
(function(e){"function"===typeof define&&define.amd?define(["jquery"],e):e(jQuery)})(function(e){var t=!1,n=!1,r=5e3,i=2e3,s=0,o=["ms","moz","webkit","o"],u=window.requestAnimationFrame||!1,a=window.cancelAnimationFrame||!1;if(!u)for(var f in o){var l=o[f];u||(u=window[l+"RequestAnimationFrame"]);a||(a=window[l+"CancelAnimationFrame"]||window[l+"CancelRequestAnimationFrame"])}var c=window.MutationObserver||window.WebKitMutationObserver||!1,h={zindex:"auto",cursoropacitymin:0,cursoropacitymax:1,cursorcolor:"#424242",cursorwidth:"5px",cursorborder:"1px solid #fff",cursorborderradius:"5px",scrollspeed:60,mousescrollstep:24,touchbehavior:!1,hwacceleration:!0,usetransition:!0,boxzoom:!1,dblclickzoom:!0,gesturezoom:!0,grabcursorenabled:!0,autohidemode:!0,background:"",iframeautoresize:!0,cursorminheight:32,preservenativescrolling:!0,railoffset:!1,bouncescroll:!0,spacebarenabled:!0,railpadding:{top:0,right:0,left:0,bottom:0},disableoutline:!0,horizrailenabled:!0,railalign:"right",railvalign:"bottom",enabletranslate3d:!0,enablemousewheel:!0,enablekeyboard:!0,smoothscroll:!0,sensitiverail:!0,enablemouselockapi:!0,cursorfixedheight:!1,directionlockdeadzone:6,hidecursordelay:400,nativeparentscrolling:!0,enablescrollonselection:!0,overflowx:!0,overflowy:!0,cursordragspeed:.3,rtlmode:"auto",cursordragontouch:!1,oneaxismousemode:"auto",scriptpath:function(){var e=document.getElementsByTagName("script"),e=e[e.length-1].src.split("?")[0];return 0<e.split("/").length?e.split("/").slice(0,-1).join("/")+"/":""}()},p=!1,d=function(){if(p)return p;var e=document.createElement("DIV"),t={haspointerlock:"pointerLockElement"in document||"mozPointerLockElement"in document||"webkitPointerLockElement"in document};t.isopera="opera"in window;t.isopera12=t.isopera&&"getUserMedia"in navigator;t.isoperamini="[object OperaMini]"===Object.prototype.toString.call(window.operamini);t.isie="all"in document&&"attachEvent"in e&&!t.isopera;t.isieold=t.isie&&!("msInterpolationMode"in e.style);t.isie7=t.isie&&!t.isieold&&(!("documentMode"in document)||7==document.documentMode);t.isie8=t.isie&&"documentMode"in document&&8==document.documentMode;t.isie9=t.isie&&"performance"in window&&9<=document.documentMode;t.isie10=t.isie&&"performance"in window&&10<=document.documentMode;t.isie9mobile=/iemobile.9/i.test(navigator.userAgent);t.isie9mobile&&(t.isie9=!1);t.isie7mobile=!t.isie9mobile&&t.isie7&&/iemobile/i.test(navigator.userAgent);t.ismozilla="MozAppearance"in e.style;t.iswebkit="WebkitAppearance"in e.style;t.ischrome="chrome"in window;t.ischrome22=t.ischrome&&t.haspointerlock;t.ischrome26=t.ischrome&&"transition"in e.style;t.cantouch="ontouchstart"in document.documentElement||"ontouchstart"in window;t.hasmstouch=window.navigator.msPointerEnabled||!1;t.ismac=/^mac$/i.test(navigator.platform);t.isios=t.cantouch&&/iphone|ipad|ipod/i.test(navigator.platform);t.isios4=t.isios&&!("seal"in Object);t.isandroid=/android/i.test(navigator.userAgent);t.trstyle=!1;t.hastransform=!1;t.hastranslate3d=!1;t.transitionstyle=!1;t.hastransition=!1;t.transitionend=!1;for(var n=["transform","msTransform","webkitTransform","MozTransform","OTransform"],r=0;r<n.length;r++)if("undefined"!=typeof e.style[n[r]]){t.trstyle=n[r];break}t.hastransform=!1!=t.trstyle;t.hastransform&&(e.style[t.trstyle]="translate3d(1px,2px,3px)",t.hastranslate3d=/translate3d/.test(e.style[t.trstyle]));t.transitionstyle=!1;t.prefixstyle="";t.transitionend=!1;for(var n="transition webkitTransition MozTransition OTransition OTransition msTransition KhtmlTransition".split(" "),i=" -webkit- -moz- -o- -o -ms- -khtml-".split(" "),s="transitionend webkitTransitionEnd transitionend otransitionend oTransitionEnd msTransitionEnd KhtmlTransitionEnd".split(" "),r=0;r<n.length;r++)if(n[r]in e.style){t.transitionstyle=n[r];t.prefixstyle=i[r];t.transitionend=s[r];break}t.ischrome26&&(t.prefixstyle=i[1]);t.hastransition=t.transitionstyle;e:{n=["-moz-grab","-webkit-grab","grab"];if(t.ischrome&&!t.ischrome22||t.isie)n=[];for(r=0;r<n.length;r++)if(i=n[r],e.style.cursor=i,e.style.cursor==i){n=i;break e}n="url(http://www.google.com/intl/en_ALL/mapfiles/openhand.cur),n-resize"}t.cursorgrabvalue=n;t.hasmousecapture="setCapture"in e;t.hasMutationObserver=!1!==c;return p=t},v=function(o,f){function l(){var e=y.win;if("zIndex"in e)return e.zIndex();for(;0<e.length&&9!=e[0].nodeType;){var t=e.css("zIndex");if(!isNaN(t)&&0!=t)return parseInt(t);e=e.parent()}return!1}function p(e,t,n){t=e.css(t);e=parseFloat(t);return isNaN(e)?(e=T[t]||0,n=3==e?n?y.win.outerHeight()-y.win.innerHeight():y.win.outerWidth()-y.win.innerWidth():1,y.isie8&&e&&(e+=1),n?e:0):e}function v(e,t,n,r){y._bind(e,t,function(r){r=r?r:window.event;var i={original:r,target:r.target||r.srcElement,type:"wheel",deltaMode:"MozMousePixelScroll"==r.type?0:1,deltaX:0,deltaZ:0,preventDefault:function(){r.preventDefault?r.preventDefault():r.returnValue=!1;return!1},stopImmediatePropagation:function(){r.stopImmediatePropagation?r.stopImmediatePropagation():r.cancelBubble=!0}};"mousewheel"==t?(i.deltaY=-.025*r.wheelDelta,r.wheelDeltaX&&(i.deltaX=-.025*r.wheelDeltaX)):i.deltaY=r.detail;return n.call(e,i)},r)}function g(e,t,n){var r,i;0==e.deltaMode?(r=-Math.floor(e.deltaX*(y.opt.mousescrollstep/54)),i=-Math.floor(e.deltaY*(y.opt.mousescrollstep/54))):1==e.deltaMode&&(r=-Math.floor(e.deltaX*y.opt.mousescrollstep),i=-Math.floor(e.deltaY*y.opt.mousescrollstep));t&&y.opt.oneaxismousemode&&0==r&&i&&(r=i,i=0);r&&(y.scrollmom&&y.scrollmom.stop(),y.lastdeltax+=r,y.debounced("mousewheelx",function(){var e=y.lastdeltax;y.lastdeltax=0;y.rail.drag||y.doScrollLeftBy(e)},15));if(i){if(y.opt.nativeparentscrolling&&n&&!y.ispage&&!y.zoomactive)if(0>i){if(y.getScrollTop()>=y.page.maxh)return!0}else if(0>=y.getScrollTop())return!0;y.scrollmom&&y.scrollmom.stop();y.lastdeltay+=i;y.debounced("mousewheely",function(){var e=y.lastdeltay;y.lastdeltay=0;y.rail.drag||y.doScrollBy(e)},15)}e.stopImmediatePropagation();return e.preventDefault()}var y=this;this.version="3.5.4";this.name="nicescroll";this.me=f;this.opt={doc:e("body"),win:!1};e.extend(this.opt,h);this.opt.snapbackspeed=80;if(o)for(var b in y.opt)"undefined"!=typeof o[b]&&(y.opt[b]=o[b]);this.iddoc=(this.doc=y.opt.doc)&&this.doc[0]?this.doc[0].id||"":"";this.ispage=/^BODY|HTML/.test(y.opt.win?y.opt.win[0].nodeName:this.doc[0].nodeName);this.haswrapper=!1!==y.opt.win;this.win=y.opt.win||(this.ispage?e(window):this.doc);this.docscroll=this.ispage&&!this.haswrapper?e(window):this.win;this.body=e("body");this.iframe=this.isfixed=this.viewport=!1;this.isiframe="IFRAME"==this.doc[0].nodeName&&"IFRAME"==this.win[0].nodeName;this.istextarea="TEXTAREA"==this.win[0].nodeName;this.forcescreen=!1;this.canshowonmouseevent="scroll"!=y.opt.autohidemode;this.page=this.view=this.onzoomout=this.onzoomin=this.onscrollcancel=this.onscrollend=this.onscrollstart=this.onclick=this.ongesturezoom=this.onkeypress=this.onmousewheel=this.onmousemove=this.onmouseup=this.onmousedown=!1;this.scroll={x:0,y:0};this.scrollratio={x:0,y:0};this.cursorheight=20;this.scrollvaluemax=0;this.observerremover=this.observer=this.scrollmom=this.scrollrunning=this.isrtlmode=!1;do this.id="ascrail"+i++;while(document.getElementById(this.id));this.hasmousefocus=this.hasfocus=this.zoomactive=this.zoom=this.selectiondrag=this.cursorfreezed=this.cursor=this.rail=!1;this.visibility=!0;this.hidden=this.locked=!1;this.cursoractive=!0;this.wheelprevented=!1;this.overflowx=y.opt.overflowx;this.overflowy=y.opt.overflowy;this.nativescrollingarea=!1;this.checkarea=0;this.events=[];this.saved={};this.delaylist={};this.synclist={};this.lastdeltay=this.lastdeltax=0;this.detected=d();var w=e.extend({},this.detected);this.ishwscroll=(this.canhwscroll=w.hastransform&&y.opt.hwacceleration)&&y.haswrapper;this.istouchcapable=!1;w.cantouch&&w.ischrome&&!w.isios&&!w.isandroid&&(this.istouchcapable=!0,w.cantouch=!1);w.cantouch&&w.ismozilla&&!w.isios&&!w.isandroid&&(this.istouchcapable=!0,w.cantouch=!1);y.opt.enablemouselockapi||(w.hasmousecapture=!1,w.haspointerlock=!1);this.delayed=function(e,t,n,r){var i=y.delaylist[e],s=(new Date).getTime();if(!r&&i&&i.tt)return!1;i&&i.tt&&clearTimeout(i.tt);if(i&&i.last+n>s&&!i.tt)y.delaylist[e]={last:s+n,tt:setTimeout(function(){y&&(y.delaylist[e].tt=0,t.call())},n)};else if(!i||!i.tt)y.delaylist[e]={last:s,tt:0},setTimeout(function(){t.call()},0)};this.debounced=function(e,t,n){var r=y.delaylist[e];(new Date).getTime();y.delaylist[e]=t;r||setTimeout(function(){var t=y.delaylist[e];y.delaylist[e]=!1;t.call()},n)};var E=!1;this.synched=function(e,t){y.synclist[e]=t;(function(){E||(u(function(){E=!1;for(e in y.synclist){var t=y.synclist[e];t&&t.call(y);y.synclist[e]=!1}}),E=!0)})();return e};this.unsynched=function(e){y.synclist[e]&&(y.synclist[e]=!1)};this.css=function(e,t){for(var n in t)y.saved.css.push([e,n,e.css(n)]),e.css(n,t[n])};this.scrollTop=function(e){return"undefined"==typeof e?y.getScrollTop():y.setScrollTop(e)};this.scrollLeft=function(e){return"undefined"==typeof e?y.getScrollLeft():y.setScrollLeft(e)};BezierClass=function(e,t,n,r,i,s,o){this.st=e;this.ed=t;this.spd=n;this.p1=r||0;this.p2=i||1;this.p3=s||0;this.p4=o||1;this.ts=(new Date).getTime();this.df=this.ed-this.st};BezierClass.prototype={B2:function(e){return 3*e*e*(1-e)},B3:function(e){return 3*e*(1-e)*(1-e)},B4:function(e){return(1-e)*(1-e)*(1-e)},getNow:function(){var e=1-((new Date).getTime()-this.ts)/this.spd,t=this.B2(e)+this.B3(e)+this.B4(e);return 0>e?this.ed:this.st+Math.round(this.df*t)},update:function(e,t){this.st=this.getNow();this.ed=e;this.spd=t;this.ts=(new Date).getTime();this.df=this.ed-this.st;return this}};if(this.ishwscroll){this.doc.translate={x:0,y:0,tx:"0px",ty:"0px"};w.hastranslate3d&&w.isios&&this.doc.css("-webkit-backface-visibility","hidden");var S=function(){var e=y.doc.css(w.trstyle);return e&&"matrix"==e.substr(0,6)?e.replace(/^.*\((.*)\)$/g,"$1").replace(/px/g,"").split(/, +/):!1};this.getScrollTop=function(e){if(!e){if(e=S())return 16==e.length?-e[13]:-e[5];if(y.timerscroll&&y.timerscroll.bz)return y.timerscroll.bz.getNow()}return y.doc.translate.y};this.getScrollLeft=function(e){if(!e){if(e=S())return 16==e.length?-e[12]:-e[4];if(y.timerscroll&&y.timerscroll.bh)return y.timerscroll.bh.getNow()}return y.doc.translate.x};this.notifyScrollEvent=document.createEvent?function(e){var t=document.createEvent("UIEvents");t.initUIEvent("scroll",!1,!0,window,1);e.dispatchEvent(t)}:document.fireEvent?function(e){var t=document.createEventObject();e.fireEvent("onscroll");t.cancelBubble=!0}:function(e,t){};w.hastranslate3d&&y.opt.enabletranslate3d?(this.setScrollTop=function(e,t){y.doc.translate.y=e;y.doc.translate.ty=-1*e+"px";y.doc.css(w.trstyle,"translate3d("+y.doc.translate.tx+","+y.doc.translate.ty+",0px)");t||y.notifyScrollEvent(y.win[0])},this.setScrollLeft=function(e,t){y.doc.translate.x=e;y.doc.translate.tx=-1*e+"px";y.doc.css(w.trstyle,"translate3d("+y.doc.translate.tx+","+y.doc.translate.ty+",0px)");t||y.notifyScrollEvent(y.win[0])}):(this.setScrollTop=function(e,t){y.doc.translate.y=e;y.doc.translate.ty=-1*e+"px";y.doc.css(w.trstyle,"translate("+y.doc.translate.tx+","+y.doc.translate.ty+")");t||y.notifyScrollEvent(y.win[0])},this.setScrollLeft=function(e,t){y.doc.translate.x=e;y.doc.translate.tx=-1*e+"px";y.doc.css(w.trstyle,"translate("+y.doc.translate.tx+","+y.doc.translate.ty+")");t||y.notifyScrollEvent(y.win[0])})}else this.getScrollTop=function(){return y.docscroll.scrollTop()},this.setScrollTop=function(e){return y.docscroll.scrollTop(e)},this.getScrollLeft=function(){return y.docscroll.scrollLeft()},this.setScrollLeft=function(e){return y.docscroll.scrollLeft(e)};this.getTarget=function(e){return!e?!1:e.target?e.target:e.srcElement?e.srcElement:!1};this.hasParent=function(e,t){if(!e)return!1;for(var n=e.target||e.srcElement||e||!1;n&&n.id!=t;)n=n.parentNode||!1;return!1!==n};var T={thin:1,medium:3,thick:5};this.getOffset=function(){if(y.isfixed)return{top:parseFloat(y.win.css("top")),left:parseFloat(y.win.css("left"))};if(!y.viewport)return y.win.offset();var e=y.win.offset(),t=y.viewport.offset();return{top:e.top-t.top+y.viewport.scrollTop(),left:e.left-t.left+y.viewport.scrollLeft()}};this.updateScrollBar=function(e){if(y.ishwscroll)y.rail.css({height:y.win.innerHeight()}),y.railh&&y.railh.css({width:y.win.innerWidth()});else{var t=y.getOffset(),n=t.top,r=t.left,n=n+p(y.win,"border-top-width",!0);y.win.outerWidth();y.win.innerWidth();var r=r+(y.rail.align?y.win.outerWidth()-p(y.win,"border-right-width")-y.rail.width:p(y.win,"border-left-width")),i=y.opt.railoffset;i&&(i.top&&(n+=i.top),y.rail.align&&i.left&&(r+=i.left));y.locked||y.rail.css({top:n,left:r,height:e?e.h:y.win.innerHeight()});y.zoom&&y.zoom.css({top:n+1,left:1==y.rail.align?r-20:r+y.rail.width+4});y.railh&&!y.locked&&(n=t.top,r=t.left,e=y.railh.align?n+p(y.win,"border-top-width",!0)+y.win.innerHeight()-y.railh.height:n+p(y.win,"border-top-width",!0),r+=p(y.win,"border-left-width"),y.railh.css({top:e,left:r,width:y.railh.width}))}};this.doRailClick=function(e,t,n){var r;y.locked||(y.cancelEvent(e),t?(t=n?y.doScrollLeft:y.doScrollTop,r=n?(e.pageX-y.railh.offset().left-y.cursorwidth/2)*y.scrollratio.x:(e.pageY-y.rail.offset().top-y.cursorheight/2)*y.scrollratio.y,t(r)):(t=n?y.doScrollLeftBy:y.doScrollBy,r=n?y.scroll.x:y.scroll.y,e=n?e.pageX-y.railh.offset().left:e.pageY-y.rail.offset().top,n=n?y.view.w:y.view.h,r>=e?t(n):t(-n)))};y.hasanimationframe=u;y.hascancelanimationframe=a;y.hasanimationframe?y.hascancelanimationframe||(a=function(){y.cancelAnimationFrame=!0}):(u=function(e){return setTimeout(e,15-Math.floor(+(new Date)/1e3)%16)},a=clearInterval);this.init=function(){y.saved.css=[];if(w.isie7mobile||w.isoperamini)return!0;w.hasmstouch&&y.css(y.ispage?e("html"):y.win,{"-ms-touch-action":"none"});y.zindex="auto";y.zindex=!y.ispage&&"auto"==y.opt.zindex?l()||"auto":y.opt.zindex;!y.ispage&&"auto"!=y.zindex&&y.zindex>s&&(s=y.zindex);y.isie&&0==y.zindex&&"auto"==y.opt.zindex&&(y.zindex="auto");if(!y.ispage||!w.cantouch&&!w.isieold&&!w.isie9mobile){var i=y.docscroll;y.ispage&&(i=y.haswrapper?y.win:y.doc);w.isie9mobile||y.css(i,{"overflow-y":"hidden"});y.ispage&&w.isie7&&("BODY"==y.doc[0].nodeName?y.css(e("html"),{"overflow-y":"hidden"}):"HTML"==y.doc[0].nodeName&&y.css(e("body"),{"overflow-y":"hidden"}));w.isios&&!y.ispage&&!y.haswrapper&&y.css(e("body"),{"-webkit-overflow-scrolling":"touch"});var o=e(document.createElement("div"));o.css({position:"relative",top:0,"float":"right",width:y.opt.cursorwidth,height:"0px","background-color":y.opt.cursorcolor,border:y.opt.cursorborder,"background-clip":"padding-box","-webkit-border-radius":y.opt.cursorborderradius,"-moz-border-radius":y.opt.cursorborderradius,"border-radius":y.opt.cursorborderradius});o.hborder=parseFloat(o.outerHeight()-o.innerHeight());y.cursor=o;var u=e(document.createElement("div"));u.attr("id",y.id);u.addClass("nicescroll-rails");var a,f,h=["left","right"],p;for(p in h)f=h[p],(a=y.opt.railpadding[f])?u.css("padding-"+f,a+"px"):y.opt.railpadding[f]=0;u.append(o);u.width=Math.max(parseFloat(y.opt.cursorwidth),o.outerWidth())+y.opt.railpadding.left+y.opt.railpadding.right;u.css({width:u.width+"px",zIndex:y.zindex,background:y.opt.background,cursor:"default"});u.visibility=!0;u.scrollable=!0;u.align="left"==y.opt.railalign?0:1;y.rail=u;o=y.rail.drag=!1;y.opt.boxzoom&&!y.ispage&&!w.isieold&&(o=document.createElement("div"),y.bind(o,"click",y.doZoom),y.zoom=e(o),y.zoom.css({cursor:"pointer","z-index":y.zindex,backgroundImage:"url("+y.opt.scriptpath+"zoomico.png)",height:18,width:18,backgroundPosition:"0px 0px"}),y.opt.dblclickzoom&&y.bind(y.win,"dblclick",y.doZoom),w.cantouch&&y.opt.gesturezoom&&(y.ongesturezoom=function(e){1.5<e.scale&&y.doZoomIn(e);.8>e.scale&&y.doZoomOut(e);return y.cancelEvent(e)},y.bind(y.win,"gestureend",y.ongesturezoom)));y.railh=!1;if(y.opt.horizrailenabled){y.css(i,{"overflow-x":"hidden"});o=e(document.createElement("div"));o.css({position:"relative",top:0,height:y.opt.cursorwidth,width:"0px","background-color":y.opt.cursorcolor,border:y.opt.cursorborder,"background-clip":"padding-box","-webkit-border-radius":y.opt.cursorborderradius,"-moz-border-radius":y.opt.cursorborderradius,"border-radius":y.opt.cursorborderradius});o.wborder=parseFloat(o.outerWidth()-o.innerWidth());y.cursorh=o;var d=e(document.createElement("div"));d.attr("id",y.id+"-hr");d.addClass("nicescroll-rails");d.height=Math.max(parseFloat(y.opt.cursorwidth),o.outerHeight());d.css({height:d.height+"px",zIndex:y.zindex,background:y.opt.background});d.append(o);d.visibility=!0;d.scrollable=!0;d.align="top"==y.opt.railvalign?0:1;y.railh=d;y.railh.drag=!1}y.ispage?(u.css({position:"fixed",top:"0px",height:"100%"}),u.align?u.css({right:"0px"}):u.css({left:"0px"}),y.body.append(u),y.railh&&(d.css({position:"fixed",left:"0px",width:"100%"}),d.align?d.css({bottom:"0px"}):d.css({top:"0px"}),y.body.append(d))):(y.ishwscroll?("static"==y.win.css("position")&&y.css(y.win,{position:"relative"}),i="HTML"==y.win[0].nodeName?y.body:y.win,y.zoom&&(y.zoom.css({position:"absolute",top:1,right:0,"margin-right":u.width+4}),i.append(y.zoom)),u.css({position:"absolute",top:0}),u.align?u.css({right:0}):u.css({left:0}),i.append(u),d&&(d.css({position:"absolute",left:0,bottom:0}),d.align?d.css({bottom:0}):d.css({top:0}),i.append(d))):(y.isfixed="fixed"==y.win.css("position"),i=y.isfixed?"fixed":"absolute",y.isfixed||(y.viewport=y.getViewport(y.win[0])),y.viewport&&(y.body=y.viewport,!1==/fixed|relative|absolute/.test(y.viewport.css("position"))&&y.css(y.viewport,{position:"relative"})),u.css({position:i}),y.zoom&&y.zoom.css({position:i}),y.updateScrollBar(),y.body.append(u),y.zoom&&y.body.append(y.zoom),y.railh&&(d.css({position:i}),y.body.append(d))),w.isios&&y.css(y.win,{"-webkit-tap-highlight-color":"rgba(0,0,0,0)","-webkit-touch-callout":"none"}),w.isie&&y.opt.disableoutline&&y.win.attr("hideFocus","true"),w.iswebkit&&y.opt.disableoutline&&y.win.css({outline:"none"}));!1===y.opt.autohidemode?(y.autohidedom=!1,y.rail.css({opacity:y.opt.cursoropacitymax}),y.railh&&y.railh.css({opacity:y.opt.cursoropacitymax})):!0===y.opt.autohidemode||"leave"===y.opt.autohidemode?(y.autohidedom=e().add(y.rail),w.isie8&&(y.autohidedom=y.autohidedom.add(y.cursor)),y.railh&&(y.autohidedom=y.autohidedom.add(y.railh)),y.railh&&w.isie8&&(y.autohidedom=y.autohidedom.add(y.cursorh))):"scroll"==y.opt.autohidemode?(y.autohidedom=e().add(y.rail),y.railh&&(y.autohidedom=y.autohidedom.add(y.railh))):"cursor"==y.opt.autohidemode?(y.autohidedom=e().add(y.cursor),y.railh&&(y.autohidedom=y.autohidedom.add(y.cursorh))):"hidden"==y.opt.autohidemode&&(y.autohidedom=!1,y.hide(),y.locked=!1);if(w.isie9mobile)y.scrollmom=new m(y),y.onmangotouch=function(e){e=y.getScrollTop();var t=y.getScrollLeft();if(e==y.scrollmom.lastscrolly&&t==y.scrollmom.lastscrollx)return!0;var n=e-y.mangotouch.sy,r=t-y.mangotouch.sx;if(0!=Math.round(Math.sqrt(Math.pow(r,2)+Math.pow(n,2)))){var i=0>n?-1:1,s=0>r?-1:1,o=+(new Date);y.mangotouch.lazy&&clearTimeout(y.mangotouch.lazy);80<o-y.mangotouch.tm||y.mangotouch.dry!=i||y.mangotouch.drx!=s?(y.scrollmom.stop(),y.scrollmom.reset(t,e),y.mangotouch.sy=e,y.mangotouch.ly=e,y.mangotouch.sx=t,y.mangotouch.lx=t,y.mangotouch.dry=i,y.mangotouch.drx=s,y.mangotouch.tm=o):(y.scrollmom.stop(),y.scrollmom.update(y.mangotouch.sx-r,y.mangotouch.sy-n),y.mangotouch.tm=o,n=Math.max(Math.abs(y.mangotouch.ly-e),Math.abs(y.mangotouch.lx-t)),y.mangotouch.ly=e,y.mangotouch.lx=t,2<n&&(y.mangotouch.lazy=setTimeout(function(){y.mangotouch.lazy=!1;y.mangotouch.dry=0;y.mangotouch.drx=0;y.mangotouch.tm=0;y.scrollmom.doMomentum(30)},100)))}},u=y.getScrollTop(),d=y.getScrollLeft(),y.mangotouch={sy:u,ly:u,dry:0,sx:d,lx:d,drx:0,lazy:!1,tm:0},y.bind(y.docscroll,"scroll",y.onmangotouch);else{if(w.cantouch||y.istouchcapable||y.opt.touchbehavior||w.hasmstouch){y.scrollmom=new m(y);y.ontouchstart=function(t){if(t.pointerType&&2!=t.pointerType)return!1;y.hasmoving=!1;if(!y.locked){if(w.hasmstouch)for(var n=t.target?t.target:!1;n;){var r=e(n).getNiceScroll();if(0<r.length&&r[0].me==y.me)break;if(0<r.length)return!1;if("DIV"==n.nodeName&&n.id==y.id)break;n=n.parentNode?n.parentNode:!1}y.cancelScroll();if((n=y.getTarget(t))&&/INPUT/i.test(n.nodeName)&&/range/i.test(n.type))return y.stopPropagation(t);!("clientX"in t)&&"changedTouches"in t&&(t.clientX=t.changedTouches[0].clientX,t.clientY=t.changedTouches[0].clientY);y.forcescreen&&(r=t,t={original:t.original?t.original:t},t.clientX=r.screenX,t.clientY=r.screenY);y.rail.drag={x:t.clientX,y:t.clientY,sx:y.scroll.x,sy:y.scroll.y,st:y.getScrollTop(),sl:y.getScrollLeft(),pt:2,dl:!1};if(y.ispage||!y.opt.directionlockdeadzone)y.rail.drag.dl="f";else{var r=e(window).width(),i=e(window).height(),s=Math.max(document.body.scrollWidth,document.documentElement.scrollWidth),o=Math.max(document.body.scrollHeight,document.documentElement.scrollHeight),i=Math.max(0,o-i),r=Math.max(0,s-r);y.rail.drag.ck=!y.rail.scrollable&&y.railh.scrollable?0<i?"v":!1:y.rail.scrollable&&!y.railh.scrollable?0<r?"h":!1:!1;y.rail.drag.ck||(y.rail.drag.dl="f")}y.opt.touchbehavior&&y.isiframe&&w.isie&&(r=y.win.position(),y.rail.drag.x+=r.left,y.rail.drag.y+=r.top);y.hasmoving=!1;y.lastmouseup=!1;y.scrollmom.reset(t.clientX,t.clientY);if(!w.cantouch&&!this.istouchcapable&&!w.hasmstouch){if(!n||!/INPUT|SELECT|TEXTAREA/i.test(n.nodeName))return!y.ispage&&w.hasmousecapture&&n.setCapture(),y.opt.touchbehavior?(n.onclick&&!n._onclick&&(n._onclick=n.onclick,n.onclick=function(e){if(y.hasmoving)return!1;n._onclick.call(this,e)}),y.cancelEvent(t)):y.stopPropagation(t);/SUBMIT|CANCEL|BUTTON/i.test(e(n).attr("type"))&&(pc={tg:n,click:!1},y.preventclick=pc)}}};y.ontouchend=function(e){if(e.pointerType&&2!=e.pointerType)return!1;if(y.rail.drag&&2==y.rail.drag.pt&&(y.scrollmom.doMomentum(),y.rail.drag=!1,y.hasmoving&&(y.lastmouseup=!0,y.hideCursor(),w.hasmousecapture&&document.releaseCapture(),!w.cantouch)))return y.cancelEvent(e)};var v=y.opt.touchbehavior&&y.isiframe&&!w.hasmousecapture;y.ontouchmove=function(t,n){if(t.pointerType&&2!=t.pointerType)return!1;if(y.rail.drag&&2==y.rail.drag.pt){if(w.cantouch&&"undefined"==typeof t.original)return!0;y.hasmoving=!0;y.preventclick&&!y.preventclick.click&&(y.preventclick.click=y.preventclick.tg.onclick||!1,y.preventclick.tg.onclick=y.onpreventclick);t=e.extend({original:t},t);"changedTouches"in t&&(t.clientX=t.changedTouches[0].clientX,t.clientY=t.changedTouches[0].clientY);if(y.forcescreen){var r=t;t={original:t.original?t.original:t};t.clientX=r.screenX;t.clientY=r.screenY}r=ofy=0;if(v&&!n){var i=y.win.position(),r=-i.left;ofy=-i.top}var s=t.clientY+ofy,i=s-y.rail.drag.y,o=t.clientX+r,u=o-y.rail.drag.x,a=y.rail.drag.st-i;y.ishwscroll&&y.opt.bouncescroll?0>a?a=Math.round(a/2):a>y.page.maxh&&(a=y.page.maxh+Math.round((a-y.page.maxh)/2)):(0>a&&(s=a=0),a>y.page.maxh&&(a=y.page.maxh,s=0));if(y.railh&&y.railh.scrollable){var f=y.rail.drag.sl-u;y.ishwscroll&&y.opt.bouncescroll?0>f?f=Math.round(f/2):f>y.page.maxw&&(f=y.page.maxw+Math.round((f-y.page.maxw)/2)):(0>f&&(o=f=0),f>y.page.maxw&&(f=y.page.maxw,o=0))}r=!1;if(y.rail.drag.dl)r=!0,"v"==y.rail.drag.dl?f=y.rail.drag.sl:"h"==y.rail.drag.dl&&(a=y.rail.drag.st);else{var i=Math.abs(i),u=Math.abs(u),l=y.opt.directionlockdeadzone;if("v"==y.rail.drag.ck){if(i>l&&u<=.3*i)return y.rail.drag=!1,!0;u>l&&(y.rail.drag.dl="f",e("body").scrollTop(e("body").scrollTop()))}else if("h"==y.rail.drag.ck){if(u>l&&i<=.3*u)return y.rail.drag=!1,!0;i>l&&(y.rail.drag.dl="f",e("body").scrollLeft(e("body").scrollLeft()))}}y.synched("touchmove",function(){y.rail.drag&&2==y.rail.drag.pt&&(y.prepareTransition&&y.prepareTransition(0),y.rail.scrollable&&y.setScrollTop(a),y.scrollmom.update(o,s),y.railh&&y.railh.scrollable?(y.setScrollLeft(f),y.showCursor(a,f)):y.showCursor(a),w.isie10&&document.selection.clear())});w.ischrome&&y.istouchcapable&&(r=!1);if(r)return y.cancelEvent(t)}}}y.onmousedown=function(e,t){if(!(y.rail.drag&&1!=y.rail.drag.pt)){if(y.locked)return y.cancelEvent(e);y.cancelScroll();y.rail.drag={x:e.clientX,y:e.clientY,sx:y.scroll.x,sy:y.scroll.y,pt:1,hr:!!t};var n=y.getTarget(e);!y.ispage&&w.hasmousecapture&&n.setCapture();y.isiframe&&!w.hasmousecapture&&(y.saved.csspointerevents=y.doc.css("pointer-events"),y.css(y.doc,{"pointer-events":"none"}));y.hasmoving=!1;return y.cancelEvent(e)}};y.onmouseup=function(e){if(y.rail.drag&&(w.hasmousecapture&&document.releaseCapture(),y.isiframe&&!w.hasmousecapture&&y.doc.css("pointer-events",y.saved.csspointerevents),1==y.rail.drag.pt))return y.rail.drag=!1,y.hasmoving&&y.triggerScrollEnd(),y.cancelEvent(e)};y.onmousemove=function(e){if(y.rail.drag&&1==y.rail.drag.pt){if(w.ischrome&&0==e.which)return y.onmouseup(e);y.cursorfreezed=!0;y.hasmoving=!0;if(y.rail.drag.hr){y.scroll.x=y.rail.drag.sx+(e.clientX-y.rail.drag.x);0>y.scroll.x&&(y.scroll.x=0);var t=y.scrollvaluemaxw;y.scroll.x>t&&(y.scroll.x=t)}else y.scroll.y=y.rail.drag.sy+(e.clientY-y.rail.drag.y),0>y.scroll.y&&(y.scroll.y=0),t=y.scrollvaluemax,y.scroll.y>t&&(y.scroll.y=t);y.synched("mousemove",function(){y.rail.drag&&1==y.rail.drag.pt&&(y.showCursor(),y.rail.drag.hr?y.doScrollLeft(Math.round(y.scroll.x*y.scrollratio.x),y.opt.cursordragspeed):y.doScrollTop(Math.round(y.scroll.y*y.scrollratio.y),y.opt.cursordragspeed))});return y.cancelEvent(e)}};if(w.cantouch||y.opt.touchbehavior)y.onpreventclick=function(e){if(y.preventclick)return y.preventclick.tg.onclick=y.preventclick.click,y.preventclick=!1,y.cancelEvent(e)},y.bind(y.win,"mousedown",y.ontouchstart),y.onclick=w.isios?!1:function(e){return y.lastmouseup?(y.lastmouseup=!1,y.cancelEvent(e)):!0},y.opt.grabcursorenabled&&w.cursorgrabvalue&&(y.css(y.ispage?y.doc:y.win,{cursor:w.cursorgrabvalue}),y.css(y.rail,{cursor:w.cursorgrabvalue}));else{var g=function(e){if(y.selectiondrag){if(e){var t=y.win.outerHeight();e=e.pageY-y.selectiondrag.top;0<e&&e<t&&(e=0);e>=t&&(e-=t);y.selectiondrag.df=e}0!=y.selectiondrag.df&&(y.doScrollBy(2*-Math.floor(y.selectiondrag.df/6)),y.debounced("doselectionscroll",function(){g()},50))}};y.hasTextSelected="getSelection"in document?function(){return 0<document.getSelection().rangeCount}:"selection"in document?function(){return"None"!=document.selection.type}:function(){return!1};y.onselectionstart=function(e){y.ispage||(y.selectiondrag=y.win.offset())};y.onselectionend=function(e){y.selectiondrag=!1};y.onselectiondrag=function(e){y.selectiondrag&&y.hasTextSelected()&&y.debounced("selectionscroll",function(){g(e)},250)}}w.hasmstouch&&(y.css(y.rail,{"-ms-touch-action":"none"}),y.css(y.cursor,{"-ms-touch-action":"none"}),y.bind(y.win,"MSPointerDown",y.ontouchstart),y.bind(document,"MSPointerUp",y.ontouchend),y.bind(document,"MSPointerMove",y.ontouchmove),y.bind(y.cursor,"MSGestureHold",function(e){e.preventDefault()}),y.bind(y.cursor,"contextmenu",function(e){e.preventDefault()}));this.istouchcapable&&(y.bind(y.win,"touchstart",y.ontouchstart),y.bind(document,"touchend",y.ontouchend),y.bind(document,"touchcancel",y.ontouchend),y.bind(document,"touchmove",y.ontouchmove));y.bind(y.cursor,"mousedown",y.onmousedown);y.bind(y.cursor,"mouseup",y.onmouseup);y.railh&&(y.bind(y.cursorh,"mousedown",function(e){y.onmousedown(e,!0)}),y.bind(y.cursorh,"mouseup",y.onmouseup));if(y.opt.cursordragontouch||!w.cantouch&&!y.opt.touchbehavior)y.rail.css({cursor:"default"}),y.railh&&y.railh.css({cursor:"default"}),y.jqbind(y.rail,"mouseenter",function(){if(!y.win.is(":visible"))return!1;y.canshowonmouseevent&&y.showCursor();y.rail.active=!0}),y.jqbind(y.rail,"mouseleave",function(){y.rail.active=!1;y.rail.drag||y.hideCursor()}),y.opt.sensitiverail&&(y.bind(y.rail,"click",function(e){y.doRailClick(e,!1,!1)}),y.bind(y.rail,"dblclick",function(e){y.doRailClick(e,!0,!1)}),y.bind(y.cursor,"click",function(e){y.cancelEvent(e)}),y.bind(y.cursor,"dblclick",function(e){y.cancelEvent(e)})),y.railh&&(y.jqbind(y.railh,"mouseenter",function(){if(!y.win.is(":visible"))return!1;y.canshowonmouseevent&&y.showCursor();y.rail.active=!0}),y.jqbind(y.railh,"mouseleave",function(){y.rail.active=!1;y.rail.drag||y.hideCursor()}),y.opt.sensitiverail&&(y.bind(y.railh,"click",function(e){y.doRailClick(e,!1,!0)}),y.bind(y.railh,"dblclick",function(e){y.doRailClick(e,!0,!0)}),y.bind(y.cursorh,"click",function(e){y.cancelEvent(e)}),y.bind(y.cursorh,"dblclick",function(e){y.cancelEvent(e)})));!w.cantouch&&!y.opt.touchbehavior?(y.bind(w.hasmousecapture?y.win:document,"mouseup",y.onmouseup),y.bind(document,"mousemove",y.onmousemove),y.onclick&&y.bind(document,"click",y.onclick),!y.ispage&&y.opt.enablescrollonselection&&(y.bind(y.win[0],"mousedown",y.onselectionstart),y.bind(document,"mouseup",y.onselectionend),y.bind(y.cursor,"mouseup",y.onselectionend),y.cursorh&&y.bind(y.cursorh,"mouseup",y.onselectionend),y.bind(document,"mousemove",y.onselectiondrag)),y.zoom&&(y.jqbind(y.zoom,"mouseenter",function(){y.canshowonmouseevent&&y.showCursor();y.rail.active=!0}),y.jqbind(y.zoom,"mouseleave",function(){y.rail.active=!1;y.rail.drag||y.hideCursor()}))):(y.bind(w.hasmousecapture?y.win:document,"mouseup",y.ontouchend),y.bind(document,"mousemove",y.ontouchmove),y.onclick&&y.bind(document,"click",y.onclick),y.opt.cursordragontouch&&(y.bind(y.cursor,"mousedown",y.onmousedown),y.bind(y.cursor,"mousemove",y.onmousemove),y.cursorh&&y.bind(y.cursorh,"mousedown",function(e){y.onmousedown(e,!0)}),y.cursorh&&y.bind(y.cursorh,"mousemove",y.onmousemove)));y.opt.enablemousewheel&&(y.isiframe||y.bind(w.isie&&y.ispage?document:y.win,"mousewheel",y.onmousewheel),y.bind(y.rail,"mousewheel",y.onmousewheel),y.railh&&y.bind(y.railh,"mousewheel",y.onmousewheelhr));!y.ispage&&!w.cantouch&&!/HTML|^BODY/.test(y.win[0].nodeName)&&(y.win.attr("tabindex")||y.win.attr({tabindex:r++}),y.jqbind(y.win,"focus",function(e){t=y.getTarget(e).id||!0;y.hasfocus=!0;y.canshowonmouseevent&&y.noticeCursor()}),y.jqbind(y.win,"blur",function(e){t=!1;y.hasfocus=!1}),y.jqbind(y.win,"mouseenter",function(e){n=y.getTarget(e).id||!0;y.hasmousefocus=!0;y.canshowonmouseevent&&y.noticeCursor()}),y.jqbind(y.win,"mouseleave",function(){n=!1;y.hasmousefocus=!1;y.rail.drag||y.hideCursor()}))}y.onkeypress=function(r){if(y.locked&&0==y.page.maxh)return!0;r=r?r:window.e;var i=y.getTarget(r);if(i&&/INPUT|TEXTAREA|SELECT|OPTION/.test(i.nodeName)&&(!i.getAttribute("type")&&!i.type||!/submit|button|cancel/i.tp)||e(i).attr("contenteditable"))return!0;if(y.hasfocus||y.hasmousefocus&&!t||y.ispage&&!t&&!n){i=r.keyCode;if(y.locked&&27!=i)return y.cancelEvent(r);var s=r.ctrlKey||!1,o=r.shiftKey||!1,u=!1;switch(i){case 38:case 63233:y.doScrollBy(72);u=!0;break;case 40:case 63235:y.doScrollBy(-72);u=!0;break;case 37:case 63232:y.railh&&(s?y.doScrollLeft(0):y.doScrollLeftBy(72),u=!0);break;case 39:case 63234:y.railh&&(s?y.doScrollLeft(y.page.maxw):y.doScrollLeftBy(-72),u=!0);break;case 33:case 63276:y.doScrollBy(y.view.h);u=!0;break;case 34:case 63277:y.doScrollBy(-y.view.h);u=!0;break;case 36:case 63273:y.railh&&s?y.doScrollPos(0,0):y.doScrollTo(0);u=!0;break;case 35:case 63275:y.railh&&s?y.doScrollPos(y.page.maxw,y.page.maxh):y.doScrollTo(y.page.maxh);u=!0;break;case 32:y.opt.spacebarenabled&&(o?y.doScrollBy(y.view.h):y.doScrollBy(-y.view.h),u=!0);break;case 27:y.zoomactive&&(y.doZoom(),u=!0)}if(u)return y.cancelEvent(r)}};y.opt.enablekeyboard&&y.bind(document,w.isopera&&!w.isopera12?"keypress":"keydown",y.onkeypress);y.bind(document,"keydown",function(e){e.ctrlKey&&(y.wheelprevented=!0)});y.bind(document,"keyup",function(e){e.ctrlKey||(y.wheelprevented=!1)});y.bind(window,"resize",y.lazyResize);y.bind(window,"orientationchange",y.lazyResize);y.bind(window,"load",y.lazyResize);if(w.ischrome&&!y.ispage&&!y.haswrapper){var b=y.win.attr("style"),u=parseFloat(y.win.css("width"))+1;y.win.css("width",u);y.synched("chromefix",function(){y.win.attr("style",b)})}y.onAttributeChange=function(e){y.lazyResize(250)};!y.ispage&&!y.haswrapper&&(!1!==c?(y.observer=new c(function(e){e.forEach(y.onAttributeChange)}),y.observer.observe(y.win[0],{childList:!0,characterData:!1,attributes:!0,subtree:!1}),y.observerremover=new c(function(e){e.forEach(function(e){if(0<e.removedNodes.length)for(var t in e.removedNodes)if(e.removedNodes[t]==y.win[0])return y.remove()})}),y.observerremover.observe(y.win[0].parentNode,{childList:!0,characterData:!1,attributes:!1,subtree:!1})):(y.bind(y.win,w.isie&&!w.isie9?"propertychange":"DOMAttrModified",y.onAttributeChange),w.isie9&&y.win[0].attachEvent("onpropertychange",y.onAttributeChange),y.bind(y.win,"DOMNodeRemoved",function(e){e.target==y.win[0]&&y.remove()})));!y.ispage&&y.opt.boxzoom&&y.bind(window,"resize",y.resizeZoom);y.istextarea&&y.bind(y.win,"mouseup",y.lazyResize);y.lazyResize(30)}if("IFRAME"==this.doc[0].nodeName){var E=function(t){y.iframexd=!1;try{var n="contentDocument"in this?this.contentDocument:this.contentWindow.document}catch(r){y.iframexd=!0,n=!1}if(y.iframexd)return"console"in window&&console.log("NiceScroll error: policy restriced iframe"),!0;y.forcescreen=!0;y.isiframe&&(y.iframe={doc:e(n),html:y.doc.contents().find("html")[0],body:y.doc.contents().find("body")[0]},y.getContentSize=function(){return{w:Math.max(y.iframe.html.scrollWidth,y.iframe.body.scrollWidth),h:Math.max(y.iframe.html.scrollHeight,y.iframe.body.scrollHeight)}},y.docscroll=e(y.iframe.body));!w.isios&&y.opt.iframeautoresize&&!y.isiframe&&(y.win.scrollTop(0),y.doc.height(""),t=Math.max(n.getElementsByTagName("html")[0].scrollHeight,n.body.scrollHeight),y.doc.height(t));y.lazyResize(30);w.isie7&&y.css(e(y.iframe.html),{"overflow-y":"hidden"});y.css(e(y.iframe.body),{"overflow-y":"hidden"});w.isios&&y.haswrapper&&y.css(e(n.body),{"-webkit-transform":"translate3d(0,0,0)"});"contentWindow"in this?y.bind(this.contentWindow,"scroll",y.onscroll):y.bind(n,"scroll",y.onscroll);y.opt.enablemousewheel&&y.bind(n,"mousewheel",y.onmousewheel);y.opt.enablekeyboard&&y.bind(n,w.isopera?"keypress":"keydown",y.onkeypress);if(w.cantouch||y.opt.touchbehavior)y.bind(n,"mousedown",y.ontouchstart),y.bind(n,"mousemove",function(e){y.ontouchmove(e,!0)}),y.opt.grabcursorenabled&&w.cursorgrabvalue&&y.css(e(n.body),{cursor:w.cursorgrabvalue});y.bind(n,"mouseup",y.ontouchend);y.zoom&&(y.opt.dblclickzoom&&y.bind(n,"dblclick",y.doZoom),y.ongesturezoom&&y.bind(n,"gestureend",y.ongesturezoom))};this.doc[0].readyState&&"complete"==this.doc[0].readyState&&setTimeout(function(){E.call(y.doc[0],!1)},500);y.bind(this.doc,"load",E)}};this.showCursor=function(e,t){y.cursortimeout&&(clearTimeout(y.cursortimeout),y.cursortimeout=0);if(y.rail){y.autohidedom&&(y.autohidedom.stop().css({opacity:y.opt.cursoropacitymax}),y.cursoractive=!0);if(!y.rail.drag||1!=y.rail.drag.pt)"undefined"!=typeof e&&!1!==e&&(y.scroll.y=Math.round(1*e/y.scrollratio.y)),"undefined"!=typeof t&&(y.scroll.x=Math.round(1*t/y.scrollratio.x));y.cursor.css({height:y.cursorheight,top:y.scroll.y});y.cursorh&&(!y.rail.align&&y.rail.visibility?y.cursorh.css({width:y.cursorwidth,left:y.scroll.x+y.rail.width}):y.cursorh.css({width:y.cursorwidth,left:y.scroll.x}),y.cursoractive=!0);y.zoom&&y.zoom.stop().css({opacity:y.opt.cursoropacitymax})}};this.hideCursor=function(e){!y.cursortimeout&&y.rail&&y.autohidedom&&!(y.hasmousefocus&&"leave"==y.opt.autohidemode)&&(y.cursortimeout=setTimeout(function(){if(!y.rail.active||!y.showonmouseevent)y.autohidedom.stop().animate({opacity:y.opt.cursoropacitymin}),y.zoom&&y.zoom.stop().animate({opacity:y.opt.cursoropacitymin}),y.cursoractive=!1;y.cursortimeout=0},e||y.opt.hidecursordelay))};this.noticeCursor=function(e,t,n){y.showCursor(t,n);y.rail.active||y.hideCursor(e)};this.getContentSize=y.ispage?function(){return{w:Math.max(document.body.scrollWidth,document.documentElement.scrollWidth),h:Math.max(document.body.scrollHeight,document.documentElement.scrollHeight)}}:y.haswrapper?function(){return{w:y.doc.outerWidth()+parseInt(y.win.css("paddingLeft"))+parseInt(y.win.css("paddingRight")),h:y.doc.outerHeight()+parseInt(y.win.css("paddingTop"))+parseInt(y.win.css("paddingBottom"))}}:function(){return{w:y.docscroll[0].scrollWidth,h:y.docscroll[0].scrollHeight}};this.onResize=function(e,t){if(!y||!y.win)return!1;if(!y.haswrapper&&!y.ispage){if("none"==y.win.css("display"))return y.visibility&&y.hideRail().hideRailHr(),!1;!y.hidden&&!y.visibility&&y.showRail().showRailHr()}var n=y.page.maxh,r=y.page.maxw,i=y.view.w;y.view={w:y.ispage?y.win.width():parseInt(y.win[0].clientWidth),h:y.ispage?y.win.height():parseInt(y.win[0].clientHeight)};y.page=t?t:y.getContentSize();y.page.maxh=Math.max(0,y.page.h-y.view.h);y.page.maxw=Math.max(0,y.page.w-y.view.w);if(y.page.maxh==n&&y.page.maxw==r&&y.view.w==i){if(y.ispage)return y;n=y.win.offset();if(y.lastposition&&(r=y.lastposition,r.top==n.top&&r.left==n.left))return y;y.lastposition=n}0==y.page.maxh?(y.hideRail(),y.scrollvaluemax=0,y.scroll.y=0,y.scrollratio.y=0,y.cursorheight=0,y.setScrollTop(0),y.rail.scrollable=!1):y.rail.scrollable=!0;0==y.page.maxw?(y.hideRailHr(),y.scrollvaluemaxw=0,y.scroll.x=0,y.scrollratio.x=0,y.cursorwidth=0,y.setScrollLeft(0),y.railh.scrollable=!1):y.railh.scrollable=!0;y.locked=0==y.page.maxh&&0==y.page.maxw;if(y.locked)return y.ispage||y.updateScrollBar(y.view),!1;!y.hidden&&!y.visibility?y.showRail().showRailHr():!y.hidden&&!y.railh.visibility&&y.showRailHr();y.istextarea&&y.win.css("resize")&&"none"!=y.win.css("resize")&&(y.view.h-=20);y.cursorheight=Math.min(y.view.h,Math.round(y.view.h*(y.view.h/y.page.h)));y.cursorheight=y.opt.cursorfixedheight?y.opt.cursorfixedheight:Math.max(y.opt.cursorminheight,y.cursorheight);y.cursorwidth=Math.min(y.view.w,Math.round(y.view.w*(y.view.w/y.page.w)));y.cursorwidth=y.opt.cursorfixedheight?y.opt.cursorfixedheight:Math.max(y.opt.cursorminheight,y.cursorwidth);y.scrollvaluemax=y.view.h-y.cursorheight-y.cursor.hborder;y.railh&&(y.railh.width=0<y.page.maxh?y.view.w-y.rail.width:y.view.w,y.scrollvaluemaxw=y.railh.width-y.cursorwidth-y.cursorh.wborder);y.ispage||y.updateScrollBar(y.view);y.scrollratio={x:y.page.maxw/y.scrollvaluemaxw,y:y.page.maxh/y.scrollvaluemax};y.getScrollTop()>y.page.maxh?y.doScrollTop(y.page.maxh):(y.scroll.y=Math.round(y.getScrollTop()*(1/y.scrollratio.y)),y.scroll.x=Math.round(y.getScrollLeft()*(1/y.scrollratio.x)),y.cursoractive&&y.noticeCursor());y.scroll.y&&0==y.getScrollTop()&&y.doScrollTo(Math.floor(y.scroll.y*y.scrollratio.y));return y};this.resize=y.onResize;this.lazyResize=function(e){e=isNaN(e)?30:e;y.delayed("resize",y.resize,e);return y};this._bind=function(e,t,n,r){y.events.push({e:e,n:t,f:n,b:r,q:!1});e.addEventListener?e.addEventListener(t,n,r||!1):e.attachEvent?e.attachEvent("on"+t,n):e["on"+t]=n};this.jqbind=function(t,n,r){y.events.push({e:t,n:n,f:r,q:!0});e(t).bind(n,r)};this.bind=function(e,t,n,r){var i="jquery"in e?e[0]:e;"mousewheel"==t?"onwheel"in y.win?y._bind(i,"wheel",n,r||!1):(e="undefined"!=typeof document.onmousewheel?"mousewheel":"DOMMouseScroll",v(i,e,n,r||!1),"DOMMouseScroll"==e&&v(i,"MozMousePixelScroll",n,r||!1)):i.addEventListener?(w.cantouch&&/mouseup|mousedown|mousemove/.test(t)&&y._bind(i,"mousedown"==t?"touchstart":"mouseup"==t?"touchend":"touchmove",function(e){if(e.touches){if(2>e.touches.length){var t=e.touches.length?e.touches[0]:e;t.original=e;n.call(this,t)}}else e.changedTouches&&(t=e.changedTouches[0],t.original=e,n.call(this,t))},r||!1),y._bind(i,t,n,r||!1),w.cantouch&&"mouseup"==t&&y._bind(i,"touchcancel",n,r||!1)):y._bind(i,t,function(e){if((e=e||window.event||!1)&&e.srcElement)e.target=e.srcElement;"pageY"in e||(e.pageX=e.clientX+document.documentElement.scrollLeft,e.pageY=e.clientY+document.documentElement.scrollTop);return!1===n.call(i,e)||!1===r?y.cancelEvent(e):!0})};this._unbind=function(e,t,n,r){e.removeEventListener?e.removeEventListener(t,n,r):e.detachEvent?e.detachEvent("on"+t,n):e["on"+t]=!1};this.unbindAll=function(){for(var e=0;e<y.events.length;e++){var t=y.events[e];t.q?t.e.unbind(t.n,t.f):y._unbind(t.e,t.n,t.f,t.b)}};this.cancelEvent=function(e){e=e.original?e.original:e?e:window.event||!1;if(!e)return!1;e.preventDefault&&e.preventDefault();e.stopPropagation&&e.stopPropagation();e.preventManipulation&&e.preventManipulation();e.cancelBubble=!0;e.cancel=!0;return e.returnValue=!1};this.stopPropagation=function(e){e=e.original?e.original:e?e:window.event||!1;if(!e)return!1;if(e.stopPropagation)return e.stopPropagation();e.cancelBubble&&(e.cancelBubble=!0);return!1};this.showRail=function(){if(0!=y.page.maxh&&(y.ispage||"none"!=y.win.css("display")))y.visibility=!0,y.rail.visibility=!0,y.rail.css("display","block");return y};this.showRailHr=function(){if(!y.railh)return y;if(0!=y.page.maxw&&(y.ispage||"none"!=y.win.css("display")))y.railh.visibility=!0,y.railh.css("display","block");return y};this.hideRail=function(){y.visibility=!1;y.rail.visibility=!1;y.rail.css("display","none");return y};this.hideRailHr=function(){if(!y.railh)return y;y.railh.visibility=!1;y.railh.css("display","none");return y};this.show=function(){y.hidden=!1;y.locked=!1;return y.showRail().showRailHr()};this.hide=function(){y.hidden=!0;y.locked=!0;return y.hideRail().hideRailHr()};this.toggle=function(){return y.hidden?y.show():y.hide()};this.remove=function(){y.stop();y.cursortimeout&&clearTimeout(y.cursortimeout);y.doZoomOut();y.unbindAll();w.isie9&&y.win[0].detachEvent("onpropertychange",y.onAttributeChange);!1!==y.observer&&y.observer.disconnect();!1!==y.observerremover&&y.observerremover.disconnect();y.events=null;y.cursor&&y.cursor.remove();y.cursorh&&y.cursorh.remove();y.rail&&y.rail.remove();y.railh&&y.railh.remove();y.zoom&&y.zoom.remove();for(var t=0;t<y.saved.css.length;t++){var n=y.saved.css[t];n[0].css(n[1],"undefined"==typeof n[2]?"":n[2])}y.saved=!1;y.me.data("__nicescroll","");var r=e.nicescroll;r.each(function(e){if(this&&this.id===y.id){delete r[e];for(var t=++e;t<r.length;t++,e++)r[e]=r[t];r.length--;r.length&&delete r[r.length]}});for(var i in y)y[i]=null,delete y[i];y=null};this.scrollstart=function(e){this.onscrollstart=e;return y};this.scrollend=function(e){this.onscrollend=e;return y};this.scrollcancel=function(e){this.onscrollcancel=e;return y};this.zoomin=function(e){this.onzoomin=e;return y};this.zoomout=function(e){this.onzoomout=e;return y};this.isScrollable=function(t){t=t.target?t.target:t;if("OPTION"==t.nodeName)return!0;for(;t&&1==t.nodeType&&!/^BODY|HTML/.test(t.nodeName);){var n=e(t),n=n.css("overflowY")||n.css("overflowX")||n.css("overflow")||"";if(/scroll|auto/.test(n))return t.clientHeight!=t.scrollHeight;t=t.parentNode?t.parentNode:!1}return!1};this.getViewport=function(t){for(t=t&&t.parentNode?t.parentNode:!1;t&&1==t.nodeType&&!/^BODY|HTML/.test(t.nodeName);){var n=e(t);if(/fixed|absolute/.test(n.css("position")))return n;var r=n.css("overflowY")||n.css("overflowX")||n.css("overflow")||"";if(/scroll|auto/.test(r)&&t.clientHeight!=t.scrollHeight||0<n.getNiceScroll().length)return n;t=t.parentNode?t.parentNode:!1}return t?e(t):!1};this.triggerScrollEnd=function(){if(y.onscrollend){var e=y.getScrollLeft(),t=y.getScrollTop();y.onscrollend.call(y,{type:"scrollend",current:{x:e,y:t},end:{x:e,y:t}})}};this.onmousewheel=function(e){if(!y.wheelprevented){if(y.locked)return y.debounced("checkunlock",y.resize,250),!0;if(y.rail.drag)return y.cancelEvent(e);"auto"==y.opt.oneaxismousemode&&0!=e.deltaX&&(y.opt.oneaxismousemode=!1);if(y.opt.oneaxismousemode&&0==e.deltaX&&!y.rail.scrollable)return y.railh&&y.railh.scrollable?y.onmousewheelhr(e):!0;var t=+(new Date),n=!1;y.opt.preservenativescrolling&&y.checkarea+600<t&&(y.nativescrollingarea=y.isScrollable(e),n=!0);y.checkarea=t;if(y.nativescrollingarea)return!0;if(e=g(e,!1,n))y.checkarea=0;return e}};this.onmousewheelhr=function(e){if(!y.wheelprevented){if(y.locked||!y.railh.scrollable)return!0;if(y.rail.drag)return y.cancelEvent(e);var t=+(new Date),n=!1;y.opt.preservenativescrolling&&y.checkarea+600<t&&(y.nativescrollingarea=y.isScrollable(e),n=!0);y.checkarea=t;return y.nativescrollingarea?!0:y.locked?y.cancelEvent(e):g(e,!0,n)}};this.stop=function(){y.cancelScroll();y.scrollmon&&y.scrollmon.stop();y.cursorfreezed=!1;y.scroll.y=Math.round(y.getScrollTop()*(1/y.scrollratio.y));y.noticeCursor();return y};this.getTransitionSpeed=function(e){var t=Math.round(10*y.opt.scrollspeed);e=Math.min(t,Math.round(e/20*y.opt.scrollspeed));return 20<e?e:0};y.opt.smoothscroll?y.ishwscroll&&w.hastransition&&y.opt.usetransition?(this.prepareTransition=function(e,t){var n=t?20<e?e:0:y.getTransitionSpeed(e),r=n?w.prefixstyle+"transform "+n+"ms ease-out":"";if(!y.lasttransitionstyle||y.lasttransitionstyle!=r)y.lasttransitionstyle=r,y.doc.css(w.transitionstyle,r);return n},this.doScrollLeft=function(e,t){var n=y.scrollrunning?y.newscrolly:y.getScrollTop();y.doScrollPos(e,n,t)},this.doScrollTop=function(e,t){var n=y.scrollrunning?y.newscrollx:y.getScrollLeft();y.doScrollPos(n,e,t)},this.doScrollPos=function(e,t,n){var r=y.getScrollTop(),i=y.getScrollLeft();(0>(y.newscrolly-r)*(t-r)||0>(y.newscrollx-i)*(e-i))&&y.cancelScroll();!1==y.opt.bouncescroll&&(0>t?t=0:t>y.page.maxh&&(t=y.page.maxh),0>e?e=0:e>y.page.maxw&&(e=y.page.maxw));if(y.scrollrunning&&e==y.newscrollx&&t==y.newscrolly)return!1;y.newscrolly=t;y.newscrollx=e;y.newscrollspeed=n||!1;if(y.timer)return!1;y.timer=setTimeout(function(){var n=y.getScrollTop(),r=y.getScrollLeft(),i,s;i=e-r;s=t-n;i=Math.round(Math.sqrt(Math.pow(i,2)+Math.pow(s,2)));i=y.newscrollspeed&&1<y.newscrollspeed?y.newscrollspeed:y.getTransitionSpeed(i);y.newscrollspeed&&1>=y.newscrollspeed&&(i*=y.newscrollspeed);y.prepareTransition(i,!0);y.timerscroll&&y.timerscroll.tm&&clearInterval(y.timerscroll.tm);0<i&&(!y.scrollrunning&&y.onscrollstart&&y.onscrollstart.call(y,{type:"scrollstart",current:{x:r,y:n},request:{x:e,y:t},end:{x:y.newscrollx,y:y.newscrolly},speed:i}),w.transitionend?y.scrollendtrapped||(y.scrollendtrapped=!0,y.bind(y.doc,w.transitionend,y.onScrollTransitionEnd,!1)):(y.scrollendtrapped&&clearTimeout(y.scrollendtrapped),y.scrollendtrapped=setTimeout(y.onScrollTransitionEnd,i)),y.timerscroll={bz:new BezierClass(n,y.newscrolly,i,0,0,.58,1),bh:new BezierClass(r,y.newscrollx,i,0,0,.58,1)},y.cursorfreezed||(y.timerscroll.tm=setInterval(function(){y.showCursor(y.getScrollTop(),y.getScrollLeft())},60)));y.synched("doScroll-set",function(){y.timer=0;y.scrollendtrapped&&(y.scrollrunning=!0);y.setScrollTop(y.newscrolly);y.setScrollLeft(y.newscrollx);if(!y.scrollendtrapped)y.onScrollTransitionEnd()})},50)},this.cancelScroll=function(){if(!y.scrollendtrapped)return!0;var e=y.getScrollTop(),t=y.getScrollLeft();y.scrollrunning=!1;w.transitionend||clearTimeout(w.transitionend);y.scrollendtrapped=!1;y._unbind(y.doc,w.transitionend,y.onScrollTransitionEnd);y.prepareTransition(0);y.setScrollTop(e);y.railh&&y.setScrollLeft(t);y.timerscroll&&y.timerscroll.tm&&clearInterval(y.timerscroll.tm);y.timerscroll=!1;y.cursorfreezed=!1;y.showCursor(e,t);return y},this.onScrollTransitionEnd=function(){y.scrollendtrapped&&y._unbind(y.doc,w.transitionend,y.onScrollTransitionEnd);y.scrollendtrapped=!1;y.prepareTransition(0);y.timerscroll&&y.timerscroll.tm&&clearInterval(y.timerscroll.tm);y.timerscroll=!1;var e=y.getScrollTop(),t=y.getScrollLeft();y.setScrollTop(e);y.railh&&y.setScrollLeft(t);y.noticeCursor(!1,e,t);y.cursorfreezed=!1;0>e?e=0:e>y.page.maxh&&(e=y.page.maxh);0>t?t=0:t>y.page.maxw&&(t=y.page.maxw);if(e!=y.newscrolly||t!=y.newscrollx)return y.doScrollPos(t,e,y.opt.snapbackspeed);y.onscrollend&&y.scrollrunning&&y.triggerScrollEnd();y.scrollrunning=!1}):(this.doScrollLeft=function(e,t){var n=y.scrollrunning?y.newscrolly:y.getScrollTop();y.doScrollPos(e,n,t)},this.doScrollTop=function(e,t){var n=y.scrollrunning?y.newscrollx:y.getScrollLeft();y.doScrollPos(n,e,t)},this.doScrollPos=function(e,t,n){function r(){if(y.cancelAnimationFrame)return!0;y.scrollrunning=!0;if(c=1-c)return y.timer=u(r)||1;var e=0,t=sy=y.getScrollTop();if(y.dst.ay){var t=y.bzscroll?y.dst.py+y.bzscroll.getNow()*y.dst.ay:y.newscrolly,n=t-sy;if(0>n&&t<y.newscrolly||0<n&&t>y.newscrolly)t=y.newscrolly;y.setScrollTop(t);t==y.newscrolly&&(e=1)}else e=1;var i=sx=y.getScrollLeft();if(y.dst.ax){i=y.bzscroll?y.dst.px+y.bzscroll.getNow()*y.dst.ax:y.newscrollx;n=i-sx;if(0>n&&i<y.newscrollx||0<n&&i>y.newscrollx)i=y.newscrollx;y.setScrollLeft(i);i==y.newscrollx&&(e+=1)}else e+=1;2==e?(y.timer=0,y.cursorfreezed=!1,y.bzscroll=!1,y.scrollrunning=!1,0>t?t=0:t>y.page.maxh&&(t=y.page.maxh),0>i?i=0:i>y.page.maxw&&(i=y.page.maxw),i!=y.newscrollx||t!=y.newscrolly?y.doScrollPos(i,t):y.onscrollend&&y.triggerScrollEnd()):y.timer=u(r)||1}t="undefined"==typeof t||!1===t?y.getScrollTop(!0):t;if(y.timer&&y.newscrolly==t&&y.newscrollx==e)return!0;y.timer&&a(y.timer);y.timer=0;var i=y.getScrollTop(),s=y.getScrollLeft();(0>(y.newscrolly-i)*(t-i)||0>(y.newscrollx-s)*(e-s))&&y.cancelScroll();y.newscrolly=t;y.newscrollx=e;if(!y.bouncescroll||!y.rail.visibility)0>y.newscrolly?y.newscrolly=0:y.newscrolly>y.page.maxh&&(y.newscrolly=y.page.maxh);if(!y.bouncescroll||!y.railh.visibility)0>y.newscrollx?y.newscrollx=0:y.newscrollx>y.page.maxw&&(y.newscrollx=y.page.maxw);y.dst={};y.dst.x=e-s;y.dst.y=t-i;y.dst.px=s;y.dst.py=i;var o=Math.round(Math.sqrt(Math.pow(y.dst.x,2)+Math.pow(y.dst.y,2)));y.dst.ax=y.dst.x/o;y.dst.ay=y.dst.y/o;var f=0,l=o;0==y.dst.x?(f=i,l=t,y.dst.ay=1,y.dst.py=0):0==y.dst.y&&(f=s,l=e,y.dst.ax=1,y.dst.px=0);o=y.getTransitionSpeed(o);n&&1>=n&&(o*=n);y.bzscroll=0<o?y.bzscroll?y.bzscroll.update(l,o):new BezierClass(f,l,o,0,1,0,1):!1;if(!y.timer){(i==y.page.maxh&&t>=y.page.maxh||s==y.page.maxw&&e>=y.page.maxw)&&y.checkContentSize();var c=1;y.cancelAnimationFrame=!1;y.timer=1;y.onscrollstart&&!y.scrollrunning&&y.onscrollstart.call(y,{type:"scrollstart",current:{x:s,y:i},request:{x:e,y:t},end:{x:y.newscrollx,y:y.newscrolly},speed:o});r();(i==y.page.maxh&&t>=i||s==y.page.maxw&&e>=s)&&y.checkContentSize();y.noticeCursor()}},this.cancelScroll=function(){y.timer&&a(y.timer);y.timer=0;y.bzscroll=!1;y.scrollrunning=!1;return y}):(this.doScrollLeft=function(e,t){var n=y.getScrollTop();y.doScrollPos(e,n,t)},this.doScrollTop=function(e,t){var n=y.getScrollLeft();y.doScrollPos(n,e,t)},this.doScrollPos=function(e,t,n){var r=e>y.page.maxw?y.page.maxw:e;0>r&&(r=0);var i=t>y.page.maxh?y.page.maxh:t;0>i&&(i=0);y.synched("scroll",function(){y.setScrollTop(i);y.setScrollLeft(r)})},this.cancelScroll=function(){});this.doScrollBy=function(e,t){var n=0,n=t?Math.floor((y.scroll.y-e)*y.scrollratio.y):(y.timer?y.newscrolly:y.getScrollTop(!0))-e;if(y.bouncescroll){var r=Math.round(y.view.h/2);n<-r?n=-r:n>y.page.maxh+r&&(n=y.page.maxh+r)}y.cursorfreezed=!1;py=y.getScrollTop(!0);if(0>n&&0>=py)return y.noticeCursor();if(n>y.page.maxh&&py>=y.page.maxh)return y.checkContentSize(),y.noticeCursor();y.doScrollTop(n)};this.doScrollLeftBy=function(e,t){var n=0,n=t?Math.floor((y.scroll.x-e)*y.scrollratio.x):(y.timer?y.newscrollx:y.getScrollLeft(!0))-e;if(y.bouncescroll){var r=Math.round(y.view.w/2);n<-r?n=-r:n>y.page.maxw+r&&(n=y.page.maxw+r)}y.cursorfreezed=!1;px=y.getScrollLeft(!0);if(0>n&&0>=px||n>y.page.maxw&&px>=y.page.maxw)return y.noticeCursor();y.doScrollLeft(n)};this.doScrollTo=function(e,t){t&&Math.round(e*y.scrollratio.y);y.cursorfreezed=!1;y.doScrollTop(e)};this.checkContentSize=function(){var e=y.getContentSize();(e.h!=y.page.h||e.w!=y.page.w)&&y.resize(!1,e)};y.onscroll=function(e){y.rail.drag||y.cursorfreezed||y.synched("scroll",function(){y.scroll.y=Math.round(y.getScrollTop()*(1/y.scrollratio.y));y.railh&&(y.scroll.x=Math.round(y.getScrollLeft()*(1/y.scrollratio.x)));y.noticeCursor()})};y.bind(y.docscroll,"scroll",y.onscroll);this.doZoomIn=function(t){if(!y.zoomactive){y.zoomactive=!0;y.zoomrestore={style:{}};var n="position top left zIndex backgroundColor marginTop marginBottom marginLeft marginRight".split(" "),r=y.win[0].style,i;for(i in n){var o=n[i];y.zoomrestore.style[o]="undefined"!=typeof r[o]?r[o]:""}y.zoomrestore.style.width=y.win.css("width");y.zoomrestore.style.height=y.win.css("height");y.zoomrestore.padding={w:y.win.outerWidth()-y.win.width(),h:y.win.outerHeight()-y.win.height()};w.isios4&&(y.zoomrestore.scrollTop=e(window).scrollTop(),e(window).scrollTop(0));y.win.css({position:w.isios4?"absolute":"fixed",top:0,left:0,"z-index":s+100,margin:"0px"});n=y.win.css("backgroundColor");(""==n||/transparent|rgba\(0, 0, 0, 0\)|rgba\(0,0,0,0\)/.test(n))&&y.win.css("backgroundColor","#fff");y.rail.css({"z-index":s+101});y.zoom.css({"z-index":s+102});y.zoom.css("backgroundPosition","0px -18px");y.resizeZoom();y.onzoomin&&y.onzoomin.call(y);return y.cancelEvent(t)}};this.doZoomOut=function(t){if(y.zoomactive)return y.zoomactive=!1,y.win.css("margin",""),y.win.css(y.zoomrestore.style),w.isios4&&e(window).scrollTop(y.zoomrestore.scrollTop),y.rail.css({"z-index":y.zindex}),y.zoom.css({"z-index":y.zindex}),y.zoomrestore=!1,y.zoom.css("backgroundPosition","0px 0px"),y.onResize(),y.onzoomout&&y.onzoomout.call(y),y.cancelEvent(t)};this.doZoom=function(e){return y.zoomactive?y.doZoomOut(e):y.doZoomIn(e)};this.resizeZoom=function(){if(y.zoomactive){var t=y.getScrollTop();y.win.css({width:e(window).width()-y.zoomrestore.padding.w+"px",height:e(window).height()-y.zoomrestore.padding.h+"px"});y.onResize();y.setScrollTop(Math.min(y.page.maxh,t))}};this.init();e.nicescroll.push(this)},m=function(e){var t=this;this.nc=e;this.steptime=this.lasttime=this.speedy=this.speedx=this.lasty=this.lastx=0;this.snapy=this.snapx=!1;this.demuly=this.demulx=0;this.lastscrolly=this.lastscrollx=-1;this.timer=this.chky=this.chkx=0;this.time=function(){return+(new Date)};this.reset=function(e,n){t.stop();var r=t.time();t.steptime=0;t.lasttime=r;t.speedx=0;t.speedy=0;t.lastx=e;t.lasty=n;t.lastscrollx=-1;t.lastscrolly=-1};this.update=function(e,n){var r=t.time();t.steptime=r-t.lasttime;t.lasttime=r;var r=n-t.lasty,i=e-t.lastx,s=t.nc.getScrollTop(),o=t.nc.getScrollLeft(),s=s+r,o=o+i;t.snapx=0>o||o>t.nc.page.maxw;t.snapy=0>s||s>t.nc.page.maxh;t.speedx=i;t.speedy=r;t.lastx=e;t.lasty=n};this.stop=function(){t.nc.unsynched("domomentum2d");t.timer&&clearTimeout(t.timer);t.timer=0;t.lastscrollx=-1;t.lastscrolly=-1};this.doSnapy=function(e,n){var r=!1;0>n?(n=0,r=!0):n>t.nc.page.maxh&&(n=t.nc.page.maxh,r=!0);0>e?(e=0,r=!0):e>t.nc.page.maxw&&(e=t.nc.page.maxw,r=!0);r?t.nc.doScrollPos(e,n,t.nc.opt.snapbackspeed):t.nc.triggerScrollEnd()};this.doMomentum=function(e){var n=t.time(),r=e?n+e:t.lasttime;e=t.nc.getScrollLeft();var i=t.nc.getScrollTop(),s=t.nc.page.maxh,o=t.nc.page.maxw;t.speedx=0<o?Math.min(60,t.speedx):0;t.speedy=0<s?Math.min(60,t.speedy):0;r=r&&60>=n-r;if(0>i||i>s||0>e||e>o)r=!1;e=t.speedx&&r?t.speedx:!1;if(t.speedy&&r&&t.speedy||e){var u=Math.max(16,t.steptime);50<u&&(e=u/50,t.speedx*=e,t.speedy*=e,u=50);t.demulxy=0;t.lastscrollx=t.nc.getScrollLeft();t.chkx=t.lastscrollx;t.lastscrolly=t.nc.getScrollTop();t.chky=t.lastscrolly;var a=t.lastscrollx,f=t.lastscrolly,l=function(){var e=600<t.time()-n?.04:.02;if(t.speedx&&(a=Math.floor(t.lastscrollx-t.speedx*(1-t.demulxy)),t.lastscrollx=a,0>a||a>o))e=.1;if(t.speedy&&(f=Math.floor(t.lastscrolly-t.speedy*(1-t.demulxy)),t.lastscrolly=f,0>f||f>s))e=.1;t.demulxy=Math.min(1,t.demulxy+e);t.nc.synched("domomentum2d",function(){t.speedx&&(t.nc.getScrollLeft()!=t.chkx&&t.stop(),t.chkx=a,t.nc.setScrollLeft(a));t.speedy&&(t.nc.getScrollTop()!=t.chky&&t.stop(),t.chky=f,t.nc.setScrollTop(f));t.timer||(t.nc.hideCursor(),t.doSnapy(a,f))});1>t.demulxy?t.timer=setTimeout(l,u):(t.stop(),t.nc.hideCursor(),t.doSnapy(a,f))};l()}else t.doSnapy(t.nc.getScrollLeft(),t.nc.getScrollTop())}},g=e.fn.scrollTop;e.cssHooks.pageYOffset={get:function(t,n,r){return(n=e.data(t,"__nicescroll")||!1)&&n.ishwscroll?n.getScrollTop():g.call(t)},set:function(t,n){var r=e.data(t,"__nicescroll")||!1;r&&r.ishwscroll?r.setScrollTop(parseInt(n)):g.call(t,n);return this}};e.fn.scrollTop=function(t){if("undefined"==typeof t){var n=this[0]?e.data(this[0],"__nicescroll")||!1:!1;return n&&n.ishwscroll?n.getScrollTop():g.call(this)}return this.each(function(){var n=e.data(this,"__nicescroll")||!1;n&&n.ishwscroll?n.setScrollTop(parseInt(t)):g.call(e(this),t)})};var y=e.fn.scrollLeft;e.cssHooks.pageXOffset={get:function(t,n,r){return(n=e.data(t,"__nicescroll")||!1)&&n.ishwscroll?n.getScrollLeft():y.call(t)},set:function(t,n){var r=e.data(t,"__nicescroll")||!1;r&&r.ishwscroll?r.setScrollLeft(parseInt(n)):y.call(t,n);return this}};e.fn.scrollLeft=function(t){if("undefined"==typeof t){var n=this[0]?e.data(this[0],"__nicescroll")||!1:!1;return n&&n.ishwscroll?n.getScrollLeft():y.call(this)}return this.each(function(){var n=e.data(this,"__nicescroll")||!1;n&&n.ishwscroll?n.setScrollLeft(parseInt(t)):y.call(e(this),t)})};var b=function(t){var n=this;this.length=0;this.name="nicescrollarray";this.each=function(e){for(var t=0,r=0;t<n.length;t++)e.call(n[t],r++);return n};this.push=function(e){n[n.length]=e;n.length++};this.eq=function(e){return n[e]};if(t)for(var r=0;r<t.length;r++){var i=e.data(t[r],"__nicescroll")||!1;i&&(this[this.length]=i,this.length++)}return this};(function(e,t,n){for(var r=0;r<t.length;r++)n(e,t[r])})(b.prototype,"show hide toggle onResize resize remove stop doScrollPos".split(" "),function(e,t){e[t]=function(){var e=arguments;return this.each(function(){this[t].apply(this,e)})}});e.fn.getNiceScroll=function(t){return"undefined"==typeof t?new b(this):this[t]&&e.data(this[t],"__nicescroll")||!1};e.extend(e.expr[":"],{nicescroll:function(t){return e.data(t,"__nicescroll")?!0:!1}});e.fn.niceScroll=function(t,n){"undefined"==typeof n&&"object"==typeof t&&!("jquery"in t)&&(n=t,t=!1);var r=new b;"undefined"==typeof n&&(n={});t&&(n.doc=e(t),n.win=e(this));var i=!("doc"in n);!i&&!("win"in n)&&(n.win=e(this));this.each(function(){var t=e(this).data("__nicescroll")||!1;t||(n.doc=i?e(this):n.doc,t=new v(n,e(this)),e(this).data("__nicescroll",t));r.push(t)});return 1==r.length?r[0]:r};window.NiceScroll={getjQuery:function(){return e}};e.nicescroll||(e.nicescroll=new b,e.nicescroll.options=h)});

/* equal height plugin ~~~~~~~~~~~~~~~~~~~~~~~~ */
;(function(window, document, $) {
    var equalHeights;
    equalHeights = $.fn.equalHeights = function() {
        this.each(function() {
            var maxHeight = 0, sameLine = false;
            $(this).children().each(function() {
                $(this).css('height', 'auto');
                if ($(this).css("float") == "left" || $(this).css("float") == "right") {
                    sameLine = true;
                }
                if($(this).outerHeight() > maxHeight) {
                    maxHeight = $(this).outerHeight();
                }
            });
            if (maxHeight > 0 && sameLine) {
                $(this).children().each(function() {
                    $(this).css('height', maxHeight);
                });
            }
        });
        return this;
    };
}(this, document, jQuery));

/* 11. global ajax loading ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
(function($) {
    "use strict";
    $.exort_loading = function() {

        var loader = {
            active: false,

            show: function() {
                if(loader.active === false) {
                    loader.active = true;
                    loader.loading_item.show().css("opacity", 0);
                }

                loader.loading_item.stop().animate({opacity: 0.7});
            },

            hide: function() {
                loader.loading_item.stop().delay(500).animate({opacity: 0}, function() {
                    loader.loading_item.hide();
                    loader.active = false;
                });
            },

            generate: function() {
                var parentObj = 'body';
                if ($(parentObj).find(".exort-ajax-loading").length < 1) {
                    loader.loading_item = $('<div class="exort-ajax-loading"></div>').hide().appendTo(parentObj);
                } else {
                    loader.loading_item = $(parentObj).find(".exort-ajax-loading");
                }
            }
        }

        loader.generate();
        return loader;
    };
})( jQuery );