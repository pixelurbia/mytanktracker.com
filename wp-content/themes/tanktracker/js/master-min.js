$(document).ready(function(){function e(e,t,a){var o={tank_id:e,param_type:t,user:a,action:"get_table_data"};console.log(o);$.post(ajaxurl,o,function(e){$("#table-"+t).html(e)})}function t(){$(".gallery-expanded").css({width:$(window).width(),height:$(window).height()})}var a,o;$(".aiosc-uploader").parent().hide();$(".type-menu .menu-item-contain").click(function(){$(".type-menu .menu-item-contain").removeClass("selected");$(this).addClass("selected");var e=$(this).attr("value");$(".stocktype").attr("value",e)});$(".tankstock-js-example-basic-multiple").select2({placeholder:{id:"-1",text:"Tag a tank or livestock"}});$(".cat-js-example-basic-multiple").select2({placeholder:{id:"-1",text:"Add a category to your post"}});$(".close-message-action").click(function(){closeGlobalMessage()});document.querySelector('div[contenteditable="true"]').addEventListener("paste",function(e){e.preventDefault();var t=e.clipboardData.getData("text/plain");document.execCommand("insertHTML",!1,t)});$("#datepicker-to").datepicker({dateFormat:"yy-mm-dd"});$("#datepicker-from").datepicker({dateFormat:"yy-mm-dd"});a=$(".mouse-tool-tip");$(".one-change").hover(function(){var e=$(this).attr("value");a.show();a.html(e)},function(){a.hide()});window.onmousemove=function(e){var t=$(".mouse-tool-tip"),a=e.clientX,o=e.clientY;t.css("top",o+20+"px");t.css("left",a+20+"px")};$(".tip").hover(function(){var e=$(this).attr("tip");a.show();a.html(e)},function(){a.hide()});$(".day.one-change");$("#loginform #user_login").attr("placeholder","Username");$("#loginform #user_pass").attr("placeholder","Password");$(".menu-button").click(function(e){e.preventDefault();$(".menu-bar").toggleClass("open")});$(".journals-btn").click(function(){$("#journal-form").toggleClass("show");$(".menu-bar").toggleClass("extended");$(".overlay").fadeToggle()});$(".journals .close").click(function(){$(".journals.form-contain").fadeToggle();$(".overlay").fadeToggle()});$.fn.serializeObject=function(){var e={},t=this.serializeArray();$.each(t,function(){if(e[this.name]){e[this.name].push||(e[this.name]=[e[this.name]]);e[this.name].push(this.value||"")}else e[this.name]=this.value||""});return e};$("#ajax-form").submit(function(t){var a,o,n,r,i,s,l,c,d,u;t.preventDefault();a=$("#ajax-form").serializeObject();o=a["action"];n=a["tank_id"];r=a["type"];i=a["user_id"];s=a["type"];s="chart"+s;if($("#"+s).length&&"new_tank_params"==o){l=chartDataConstructor(a);c=l[0];d=l[1];u=l[2]}if(0==$(this).valid())console.log("Form not valid - Error 201");else{$.post(ajaxurl,a,function(e){console.log(e)});console.log(a);if(a="0"){$(".overlay").fadeToggle();$(".menu-bar").toggleClass("extended");$(".form-contain").toggleClass("show")}else{$(".form-contain").html("There was an error - please contact the administrator. Error 78");console.log("form did not submit - error 78")}if($("#"+s).length&&"param_form"==o){addData(c,d,u);e(n,r,i)}}});$("#journal-img").on("change",function(){var e,t,a=this.value,o=a.lastIndexOf("\\");o>=0&&(a=a.substring(o+1));e=$("#journal-img")[0].files;for(t=0;t<e.length;t++){fileSize=e[t].size;if(fileSize>1e7){alert("You have exceeded the maximum file upload size for one or more of your images. Please correct this before submiting.");$("#journal-img").value=""}$("#post-images").html("");return!1}});$("#journal-form").submit(function(e){var t,a;e.preventDefault();t='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(t);a=new FormData(this);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:a,success:function(e){if("limit"==e){$(".global-error").html("You need to wait at least 60 seconds before posting again.");$(".global-error").fadeToggle();$(".global-error").delay(2e3).fadeToggle();$("#journal-form").toggleClass("show");$(".menu-bar").toggleClass("extended");$(".overlay").fadeToggle();$("#journal-form .status").html("What is goin on today?");$(".spinner-loader").remove()}else{$(".global-suc").html("Journal has been logged.");$(".global-suc").fadeToggle();$(".global-suc").delay(2e3).fadeToggle();$("#journal-form").toggleClass("show");$(".menu-bar").toggleClass("extended");$(".overlay").fadeToggle();$("#journal-form .status").html("What is goin on today?");$(".spinner-loader").remove();$("#journal-img").value="";$("#post-images").html("")}},error:function(e){}})});$("#j-status").focus(function(){$(this).find("i").remove()});$("#j-status").focusout(function(){var e=$(this).html();$("#status-content").attr("value",e)});$(".select_tank .fa-search").click(function(){var e=$(this).attr("tankid");$(".tank-menu a").each(function(){var t=$(this).attr("name"),a=t+"?tank_id="+e;$(this).attr("href",a)})});$(".select_tank .fa-flask").click(function(){var e=$(this).attr("tankid");$(".tank-menu a").each(function(){var t=$(this).attr("name"),a=t+"?tank_id="+e;$(this).attr("href",a)});window.location.href="/parameters?tank_id="+e});$("#export").click(function(e){var t,a,o;e.preventDefault();t=$(this).attr("param_type");a=$(this).attr("curuser");o=$(this).attr("tank_id");window.open("/export-param-table?tank_id="+o+"&curuser="+a+"&param_type="+t,"_blank")});$("#j-status").focus(function(){$(this).find("i").remove()});$("#j-status").focusout(function(){var e=$(this).html();$("#status-content").attr("value",e)});o=function e(t){var a=decodeURIComponent(window.location.search.substring(1)),o=a.split("&"),n,r;for(r=0;r<o.length;r++){n=o[r].split("=");if(n[0]===t)return void 0===n[1]||n[1]}};$(".wrap").on("click",".gallery-item",function(){var e=$(this).find("img").attr("full"),a='<div class="gallery-expanded"><div class="gal-close"><i class="fas fa-times-circle fa-lg"></i></div><img src="'+e+'"></div>';$(".overlay").show();$(".overlay").before(a);$(".menu-bar").css("top","-50px");t()});$(".wrap").on("click",".gal-close",function(){$(".overlay").hide();$(".gallery-expanded").remove();$(".menu-bar").css("top","0px");$(this).remove()});$(window).resize(function(){t()})});$(document).ready(function(){Object.entries=function(e){var t=Object.keys(e),a=t.length,o=new Array(a);while(a--)o[a]=[t[a],e[t[a]]];return o}});$(document).ready(function(){function e(){setTimeout(function(){location.reload()},500)}Object.entries=function(e){var t=Object.keys(e),a=t.length,o=new Array(a);while(a--)o[a]=[t[a],e[t[a]]];return o};$(".stock-next-step").click(function(){$("#livestock-form .step-one").fadeToggle("fast");$("#livestock-form .step-two").fadeToggle("slow")});$(".stock-prev-step").click(function(){$("#livestock-form .step-one").fadeToggle("slow");$("#livestock-form .step-two").fadeToggle("fast")});$(".stock-message-action").click(function(){var e=$(this).attr("stock_id"),t=$(this).attr("nonce");console.log("stock-message-action");$(".global-message .message").text("Are you sure you want to delete this entry?");$(".confirmation-btn").attr("stock_id",e);$(".confirmation-btn").attr("nonce",t);$(".confirmation-btn").addClass("stock-confirmation-btn");$(".message-action").addClass("stock-message-action");$(".global-message").fadeToggle();$(".overlay").fadeToggle()});$(".global-message").on("click",".stock-confirmation-btn",function(){var t=$(this).attr("nonce"),a=$(this).attr("stock_id");data={action:"del_livestock",ajax_form_nonce_del_stock:t,stock_id:a};console.log(data);$.ajax({url:ajaxurl,method:"post",data:data,success:function(t){console.log("Entry Deleted");e()},error:function(e){console.log("Eror 8373")}})});$("#stock_filter a").click(function(){var e,t,a;$(this).parent().find(".current").removeClass("current");$(this).addClass("current");e=$(this).attr("value");t=$(this).parent().attr("tank_id");a='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(a);data={action:"list_of_stock",tank_id:t,stock_type:e};console.log(data);$.ajax({url:ajaxurl,method:"post",data:data,success:function(e){$(".stock-list").html(e);$(".spinner-loader").remove()},error:function(e){console.log("Eror 3439")}})});$(".add-livestock").click(function(){$(".add-livestock-form").toggleClass("extended");$(".overlay").fadeToggle();$(".menu-bar").toggleClass("extended-more")});$("#livestock-form").submit(function(t){var a,o,n;t.preventDefault();if($("#livestock-form .stock-name").val()){$(".global-error").removeClass("show");a=new FormData;o=$("#livestock-form").serializeArray();$.each(o,function(e,t){a.append(t.name,t.value)});n=$("#Livestock-output").attr("src");a.append("file",n);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:a,success:function(t){console.log(t);e()},error:function(e){console.log(a)}})}else{$(".global-error").html("Your livestock needs a name.");$(".global-error").addClass("show")}});$(".edit-stock").click(function(){var e=$(this).parent();if(e.find("li").hasClass("hide")){e.find("li.hide span").text("Edit Value");e.find("li.hide").addClass("new-value");e.find("li").removeClass("hide")}e.find("li span").attr("contenteditable","true");e.find("li span").toggleClass("tankEditable");$(this).hide();e.find(".save-tank-stock").removeClass("hide");e.find(".del-stock").removeClass("hide");e.find(".stock-update-img").removeClass("hide")});$(".save-tank-stock").click(function(){var t,a,o,n,r,i,s,l,c,d;$("li.new-value span").each(function(){"Edit Value"==$(this).text()&&$(this).text("")});t=$(this).attr("stock_id"),a=$(this).attr("nonce"),o=$(this).parent(),n=o.find(".name span").text(),r=o.find(".species span").text(),i=o.find(".age span").text(),s=o.find(".status span").text(),l=o.find(".sex span").text(),c=o.find(".count span").text();d='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(d);data={action:"update_user_stock",ajax_form_nonce_save_stock:a,stock_id:t,stock_name:n,stock_species:r,stock_age:i,stock_status:s,stock_sex:l,stock_count:c};console.log(data);$.ajax({url:ajaxurl,method:"post",data:data,success:function(t){console.log(t);console.log("Entry Updated");e()},error:function(e){console.log("Eror 8937987")}})});$(".stock-photo-img").change(function(t){var a,o,n,r,i;t.preventDefault();console.log("hello from the other side");a=$(this).parent().parent();o=new FormData;n='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(n);console.log(a);r=a.serializeArray();$.each(r,function(e,t){o.append(t.name,t.value)});i=a.find(".stock-photo-img")[0].files[0];o.append("file",i);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:o,success:function(t){console.log(t);console.log("working");e()},error:function(e){console.log(o);console.log("error 9890890")}})})});$(document).ready(function(){function e(){$(".frost").fadeOut();$(".step-three").delay(400).fadeIn();setTimeout(function(){window.location="/tanks/"},1500)}Object.entries=function(e){var t=Object.keys(e),a=t.length,o=new Array(a);while(a--)o[a]=[t[a],e[t[a]]];return o};$("#skip-add-tank").click(function(){e()});$(".add-tank").click(function(){$(".add-tank-form").toggleClass("extended");$(".overlay").fadeToggle();$(".menu-bar").toggleClass("extended-more")});$("#tank-form").submit(function(t){var a,o,n,r,i,s,l,c;t.preventDefault();if($("#tank-form .tank-name").val()){$(".global-error").removeClass("show");a=$("#regi-form .username").val();$("#tank-form .verfication").attr("value",a);console.log($("#tank-form .verfication").val());o=new FormData;n=$("#tank-form").serializeArray();$.each(n,function(e,t){o.append(t.name,t.value)});r=$("#tank-img")[0].files[0];if($(r).length){i=r["type"];s=["image/jpeg","image/pjpeg","image/jpeg","image/pjpeg","image/gif","image/png"];l=$.inArray(i,s);if(-1==$.inArray(i,s)){$(".global-error").html("The image you uploaded is not a valid image type. jpeg/png/gif are allowed.");$(".global-error").addClass("show");return}o.append("file",r)}c='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(c);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:o,success:function(t){e()},error:function(e){}})}else{$(".global-error").html("Your tank needs a name.");$(".global-error").addClass("show")}});$(".global-message").on("click",".tank-confirmation-btn",function(){var e=$(this).attr("tank_id"),t=$(this).attr("nonce"),a=$(this).attr("parent").parent=$("."+a);data={action:"del_tank",ajax_form_nonce_del_tank:t,tank_id:e};console.log(data);$.ajax({url:ajaxurl,method:"post",data:data,success:function(e){console.log(e);$(".removeTank").remove();closeGlobalMessage()},error:function(e){console.log("Eror 0937")}})});$(".wrap").on("click",".delete-tank",function(){var e=$(this).attr("tank_id"),t=$(this).attr("param_id"),a=$(this).attr("nonce");$(this).parent().parent().parent().addClass("removeTank");$(".global-message .message").text("Are you sure you want to delete this entry and all of it's associated data? This includes, images, posts, favs, parameters and livestock. This cannot be undone.");$(".confirmation-btn").attr("tank_id",e);$(".confirmation-btn").attr("nonce",a);$(".confirmation-btn").attr("parent",parent);$(".confirmation-btn").addClass("tank-confirmation-btn");$(".message-action").addClass("tank-message-action");$(".global-message").fadeToggle();$(".overlay").fadeToggle()});$(".edit-tank").click(function(){var e=$(this).parent().parent();if(e.find("span").hasClass("hide")){e.find("span.hide i").text("Edit Value");e.find("span.hide").addClass("new-value");e.find("span").removeClass("hide")}e.find(".tank_info").attr("contenteditable","true");e.find(".tank_info").toggleClass("tankEditable");$(this).hide();e.find(".save-edit-tank").show();e.find(".delete-tank").show();e.parent().find(".image-change").show()});$(".save-edit-tank").click(function(){var t=$(this).attr("tank_id"),a=$(this).attr("nonce"),o=$(this).parent().parent(),n=o.find(".tank_name").text(),r=o.find(".tank_volume").text(),i=o.find(".tank_dimensions").text(),s=o.find(".tank_model").text(),l=o.find(".tank_make").text();$(".overlay").after('<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>');data={action:"update_user_tank",ajax_form_nonce_update_tank:a,tank_id:t,tank_name:n,tank_volume:r,tank_dimensions:i,tank_model:s,tank_make:l};console.log(data);$.ajax({url:ajaxurl,method:"post",data:data,success:function(t){console.log("Entry Updated");e()},error:function(e){console.log("Eror 976524")}})});$(".tank-photo-img").change(function(t){var a,o,n,r,i,s,l,c;t.preventDefault();console.log("hello from the other side");a=$(this).parent().parent();o=new FormData;n='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(n);console.log(a);r=a.serializeArray();$.each(r,function(e,t){o.append(t.name,t.value)});i=a.find(".tank-photo-img")[0].files[0];if($(i).length){s=i["type"];l=["image/jpeg","image/pjpeg","image/jpeg","image/pjpeg","image/gif","image/png"];c=$.inArray(s,l);if(-1==$.inArray(s,l)){$(".global-error").html("The image you uploaded is not a valid image type. jpeg/png/gif are allowed.");$(".global-error").addClass("show");$(".ias-spinner").remove();return}o.append("file",i)}$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:o,success:function(t){console.log(t);console.log("working");e()},error:function(e){console.log(o);console.log("error")}})})});$(document).ready(function(){$(".wrap").on("click",".post-options",function(){$(this).parent().find(".post-options-menu").fadeToggle()});$(".wrap").on("click",".report-this-post",function(){var e,t,a,o,n,r;console.log("report");$(this).parent().parent().remove();e=$(this).attr("post_id");t=$(this).attr("reporting_user");a=$(this).attr("auth_id");o=$(this).attr("report_nonce");n=$(this).attr("content_type");r={action:"mod_log",ref_id:e,content_type:n,reporting_user_id:t,author_id:a,report_ajax_nonce:o};console.log(r);$.ajax({url:ajaxurl,method:"post",data:r,success:function(e){console.log("success");$(".post-options-menu").hide();$(".global-suc").html("Thank you for your report.");$(".global-suc").fadeToggle();$(".global-suc").delay(2e3).fadeToggle()},error:function(e){console.log("error 97897");console.log(r)}})});$(".wrap").on("click",".mod-tool-action",function(){var e=$(this).attr("report_id"),t=$(this).attr("nonce"),a=$(this).attr("name"),o={action:"update_mod_log",report_id:e,ajax_form_mod_log:t,mod_approval:a};console.log(o);$.ajax({url:ajaxurl,method:"post",data:o,success:function(e){console.log("success");location.reload()},error:function(e){console.log("error 97897");console.log(o)}})});$(".save-user-post").click(function(){var e,t,a,o;event.preventDefault();e=$(this).attr("post_id");t=$(".the_post_content").html();a=$(this).attr("nonce");o={action:"update_user_post",ajax_form_nonce_save_post:a,post_id:e,the_post_content:t};console.log(o);$.ajax({url:ajaxurl,method:"post",data:o,success:function(e){console.log("success");URL=document.URL;URL=URL.replace("edit=yes","");window.location=URL},error:function(e){console.log("error 97897");console.log(o)}})});$(".category-filter a").click(function(){var e,t=$(this).attr("value"),a={},o=location.search.substring(1),n=/([^&=]+)=([^&]*)/g;while(e=n.exec(o))a[decodeURIComponent(e[1])]=decodeURIComponent(e[2]);a["cats"]=t;location.search=$.param(a)});$(".wrap").on("click",".fave",function(e){var t,a,o,n,r;e.preventDefault();if($(this).hasClass("static")){t="un_favorite_post";$(this).removeClass("static")}else{t="favorite_post";$(this).addClass("static");$(this).html('<i class="fas fa-heart"></i> Faved')}a=$(this).attr("ref_id");o=$(this).attr("fav_ajax_nonce");n=$(this).attr("user");r={ref_id:a,user:n,action:t,fav_ajax_nonce:o};console.log(r);$.ajax({url:ajaxurl,method:"post",data:r,success:function(e){console.log("success")},error:function(e){console.log("error 124");console.log(r)}})})});$(document).ready(function(){function e(){var e,t=new Date,a=t.getFullYear(),o=t.getMonth()+1,n=t.getDate(),r=t.getMinutes(),i=t.getSeconds(),s=t.getHours();s>12?s-=12:0===s&&(s=12);1==o.toString().length&&(o="0"+o);1==n.toString().length&&(n="0"+n);1==s.toString().length&&(s="0"+s);1==r.toString().length&&(r="0"+r);1==i.toString().length&&(i="0"+i);e=a+"-"+o+"-"+n+" "+s+":"+r+":"+i;return e}function t(){var e=$("#datepicker-from").datepicker("option","dateFormat","yy-mm-dd").val(),t=$("#datepicker-to").datepicker("option","dateFormat","yy-mm-dd").val(),a=o("tank_id");$("#ui-datepicker-div").css("display","none");$.ajax({url:"/paramtableque?"+"tank_id="+a+"&date_start="+e+"&date_end="+t,success:function(e){console.log("working");console.log(e);$(".params").html(e)}})}function a(){var e=$("#datepicker-from").datepicker("option","dateFormat","yy-mm-dd").val(),t=$("#datepicker-to").datepicker("option","dateFormat","yy-mm-dd").val(),a=o("tank_id");$("#ui-datepicker-div").css("display","none");$.ajax({url:"/activity-que?"+"tank_id="+a+"&date_start="+e+"&date_end="+t,success:function(e){console.log("working");console.log(e);$(".activities").html(e)}})}$(".global-message").on("click",".param-confirmation-btn",function(){var e=$(this).attr("tank_id"),t=$(this).attr("param_id"),a=$(this).attr("nonce"),o=$(this).attr("parent").parent=$("."+o);data={action:"del_tank_params",ajax_form_nonce_del_param:a,tank_id:e,param_id:t};console.log(data);$.ajax({url:ajaxurl,method:"post",data:data,success:function(e){console.log(e);$(".removeParam").remove();closeGlobalMessage()},error:function(e){console.log("Eror 6300")}})});var o=function e(t){var a=decodeURIComponent(window.location.search.substring(1)),o=a.split("&"),n,r;for(r=0;r<o.length;r++){n=o[r].split("=");if(n[0]===t)return void 0===n[1]||n[1]}};$(".param-filters").click(function(){t()});$(".param-table-filters").click(function(){t();a()});$(".wrap").on("click",".del-param-input",function(){var e=$(this).attr("tank_id"),t=$(this).attr("param_id"),a=$(this).attr("nonce");$(this).parent().parent().addClass("removeParam");$(".global-message .message").text("Are you sure you want to delete this entry?");$(".confirmation-btn").attr("param_id",t);$(".confirmation-btn").attr("tank_id",e);$(".confirmation-btn").attr("nonce",a);$(".confirmation-btn").attr("parent",parent);$(".confirmation-btn").addClass("param-confirmation-btn");$(".message-action").addClass("param-message-action");$(".global-message").fadeToggle();$(".overlay").fadeToggle()});$(".wrap").on("click",".edit-param-input",function(){$(".saved-row").find(".param_value").attr("contenteditable","true");$(".saved-row").find(".param_value").addClass("editable")});$(".wrap").on("click",".add-param-input",function(){$("tbody tr").first().next().before(inputRow)});$("body").on("focus",".param_value",function(){}).on("blur keyup paste input","[contenteditable]",function(){$(this).parent().addClass("dirty");$(this).addClass("dirty");window.onbeforeunload=function(){return"Are you sure you want to leave?"}});$(".wrap").on("click",".save-param-input",function(){var e,a;nonce=$(this).attr("nonce");e={action:"save_tank_params",ajax_form_nonce_save_param:nonce,newParams:[],editedParams:[]};a=0;$(".param-table tr.new-input.dirty").each(function(){var t=$(this).attr("tank_id"),o=$(this).find(".param_type").val(),n=$(this).find(".param_value").val(),r=$(this).find(".param_value").parent().hasClass("dirty");console.log(r);if("Parameter"==o){$(this).find(".param_type").parent().addClass("error-cell");a++}if(!$.isNumeric(n)||0==r){$(this).find(".param_value").parent().addClass("error-cell");a++}console.log(a);param={};param["param_type"]=o;param["value"]=n;param["tank_id"]=t;e.newParams.push(param)});$(".param-table tr.saved-row.dirty").each(function(){var t=$(this).attr("tank_id"),o=$(this).attr("param_id"),n=$(this).parent().parent(),r=$(this).find(".param_type").val(),i=$(this).find(".param_value").text(),s=$(this).find(".param_value").parent().hasClass("dirty");console.log(s);if(!$.isNumeric(i)||0==s){$(this).find(".param_value").parent().addClass("error-cell");a++}param={};param["param_id"]=o;param["value"]=i;param["tank_id"]=t;e.editedParams.push(param)});console.log(e);if(0!=a){$(".global-error").html("Please enter a parameter type and or correct parameter value.");$(".global-error").addClass("show");setTimeout(function(){$(".global-error").removeClass("show")},2500)}else $.ajax({url:ajaxurl,method:"post",data:e,success:function(e){console.log(e);t()},error:function(e){console.log("Eror 6300")}})})});$(document).ready(function(){function e(){var e,t=new Date,a=t.getFullYear(),o=t.getMonth()+1,n=t.getDate(),r=t.getMinutes(),i=t.getSeconds(),s=t.getHours();s>12?s-=12:0===s&&(s=12);1==o.toString().length&&(o="0"+o);1==n.toString().length&&(n="0"+n);1==s.toString().length&&(s="0"+s);1==r.toString().length&&(r="0"+r);1==i.toString().length&&(i="0"+i);e=a+"-"+o+"-"+n+" "+s+":"+r+":"+i;return e}function t(){var e=$("#datepicker-from").datepicker("option","dateFormat","yy-mm-dd").val(),t=$("#datepicker-to").datepicker("option","dateFormat","yy-mm-dd").val(),o=a("tank_id");$("#ui-datepicker-div").css("display","none");$.ajax({url:"/activity-que?"+"tank_id="+o+"&date_start="+e+"&date_end="+t,success:function(e){console.log("working");console.log(e);$(".activities").html(e)}})}var a=function e(t){var a=decodeURIComponent(window.location.search.substring(1)),o=a.split("&"),n,r;for(r=0;r<o.length;r++){n=o[r].split("=");if(n[0]===t)return void 0===n[1]||n[1]}};$(".wrap").on("click",".add-activity-input",function(){$(".activity-table tr").first().next().before(activityRow)});$(".wrap").on("click",".save-activity-input",function(){var e,a;nonce=$(this).attr("nonce");e={action:"save_tank_activity",ajax_form_nonce_save_activity:nonce,newActivity:[],editedActitiy:[]};a=0;$(".activity-table tr.new-activity-row").each(function(){var t=$(this).attr("tank_id"),a=$(this).find(".activity_type").val(),o=$(this).find(".product").val(),n=$(this).find(".quantity").val(),r={};r["tank_id"]=t;r["activity_type"]=a;r["product"]=o;r["quantity"]=n;e.newActivity.push(r)});console.log(e);$.ajax({url:ajaxurl,method:"post",data:e,success:function(e){console.log(e);t()},error:function(e){console.log("Eror 6300")}})})});$(document).ready(function(){function e(){$(".step-one").fadeOut();$(".frost").css({height:"570px"});$(".step-two").delay(400).fadeIn()}$.fn.serializeObject=function(){var e={},t=this.serializeArray();$.each(t,function(){if(e[this.name]){e[this.name].push||(e[this.name]=[e[this.name]]);e[this.name].push(this.value||"")}else e[this.name]=this.value||""});return e};$("#regi-form").submit(function(t){var a,o,n,r,i;t.preventDefault();a=$(".pass-2").val();o=$(".pass-1").val();n=$(".email").val();console.log($(".email").val());String.prototype.contains=function(e){return-1!=this.indexOf(e)};if(a==o&&"undefined"!=o&&null!=o)if(null!=n&&n.contains("@")){r=$(".tos-agreement:checkbox:checked").length>0;if(0!=r){i=$("#regi-form").serializeObject();console.log(i);$.post(ajaxurl,i,function(t){console.log(t);if("sucess"==t)e();else{$(".global-error").html(t);$(".global-error").addClass("show")}})}else{$(".global-error").html("You must read and agree to the Terms of Service");$(".global-error").addClass("show")}}else{$(".global-error").html("A valid Email is required.");$(".global-error").addClass("show")}});$("#regi-form .marketing-agreement").change(function(){$(this).val("no")});$("#regi-form .regi-validate").change(function(){var e,t,a=$(this).val(),o=$("#ajax_form_nonce").val();console.log(o);e=$(this).hasClass("username")?"user_nicename":"user_email";t={attribute:a,nonce:o,checker:e,action:"validate_regi_form"};console.log(t);$.post(ajaxurl,t,function(e){console.log(e);if(1==e){console.log("conflict");$("#regi-form .username").css({color:"#ff5050"});$("#regi-form .email").css({color:"#ff5050"});$(".global-error").html("Sorry about that, that username or email already exist.");$(".global-error").addClass("show")}else{console.log("no conflict");$("#regi-form .username").css({color:"#fff"});$("#regi-form .email").css({color:"#fff"});$(".global-error").removeClass("show")}})});$("#regi-form .pass-2").keyup(function(){if($(this).val()==$(".pass-1").val()){$("#regi-form .pass-1").css({color:"#fff"});$("#regi-form .pass-2").css({color:"#fff"});$(".global-error").removeClass("show");$(".account-reg").css({opacity:"1"})}else{$(".account-reg").css({opacity:"0.3"});$("#regi-form .pass-1").css({color:"#ff5050"});$("#regi-form .pass-2").css({color:"#ff5050"});$(".global-error").html("Hmm, your passwords do not match, please fix that before we continue.");$(".global-error").addClass("show")}})});$(document).ready(function(){$("#trello-form").submit(function(e){var t,a,o;e.preventDefault();t=new FormData;a=$(this).serializeArray();$.each(a,function(e,a){t.append(a.name,a.value)});o='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(o);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:t,success:function(e){$(".spinner-loader").remove();$(".global-suc").html("Thank you for your report.");$(".global-suc").fadeToggle();$(".global-suc").delay(2e3).fadeToggle();setTimeout(function(){window.location="/tanks/"},2200)},error:function(e){}})})});$(document).ready(function(){Object.entries=function(e){var t=Object.keys(e),a=t.length,o=new Array(a);while(a--)o[a]=[t[a],e[t[a]]];return o};$.fn.serializeObject=function(){var e={},t=this.serializeArray();$.each(t,function(){if(e[this.name]){e[this.name].push||(e[this.name]=[e[this.name]]);e[this.name].push(this.value||"")}else e[this.name]=this.value||""});return e};$("#pass-reset-form").submit(function(e){var t,a,o;e.preventDefault();t=new FormData;a=$(this).serializeArray();$.each(a,function(e,a){t.append(a.name,a.value)});o='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(o);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:t,success:function(e){$(".spinner-loader").remove();$(".global-suc").html("An email has been sent to the provided email.");$(".global-suc").fadeToggle();$(".global-suc").delay(2e3).fadeToggle();setTimeout(function(){window.location="/user-login/"},2e3)},error:function(e){}})});$("#pass-reseting-form").submit(function(e){var t,a,o;e.preventDefault();t=new FormData;a=$(this).serializeArray();$.each(a,function(e,a){t.append(a.name,a.value)});o='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(o);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:t,success:function(e){console.log(e);$(".spinner-loader").remove();$(".global-suc").html("Your password has been succesfully changed.");$(".global-suc").fadeToggle();$(".global-suc").delay(2e3).fadeToggle();setTimeout(function(){window.location="/user-login/"},2e3)},error:function(e){console.log(e)}})});$("#pass-reset-form .email-validate").keyup(function(){var e=$(this).val(),t=$("#ajax_form_nonce").val(),a="user_email",o={attribute:e,nonce:t,checker:a,action:"validate_regi_form"};e.indexOf("@")>=0&&$.post(ajaxurl,o,function(e){if(1==e){$(".btn.pass-reset").removeClass("hide");$(".bad-btn").hide();$(".global-error").removeClass("show")}else{$(".btn.pass-reset").addClass("hide");$(".bad-btn").show();$(".global-error").html("That email does not match our records.");$(".global-error").addClass("show")}})});$("#pass-reseting-form .pass-2").keyup(function(){var e=$(this).val(),t=$(".pass-1").val();if(e==t||t==e){$("#pass-reseting-form .pass-1").css({color:"#fff"});$("#pass-reseting-form .pass-2").css({color:"#fff"});$(".global-error").removeClass("show");$(".btn.pass-reset").removeClass("hide");$(".bad-btn").hide()}else{$("#pass-reseting-form .pass-1").css({color:"#ff5050"});$("#pass-reseting-form .pass-2").css({color:"#ff5050"});$(".global-error").html("Hmm, your passwords do not match, please fix that before we continue.");$(".global-error").addClass("show");$(".btn.pass-reset").addClass("hide");$(".bad-btn").show()}})});