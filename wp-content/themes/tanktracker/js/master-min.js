$(document).ready(function(){function e(e,a,t){var n={tank_id:e,param_type:a,user:t,action:"get_table_data"};$.post(ajaxurl,n,function(e){$("#table-"+a).html(e)})}function a(){$(".gallery-expanded").css({width:$(window).width(),height:$(window).height()})}var t,n;$(".aiosc-uploader").parent().hide();$(".type-menu .menu-item-contain").click(function(){$(".type-menu .menu-item-contain").removeClass("selected");$(this).addClass("selected");var e=$(this).attr("value");$(".stocktype").attr("value",e)});$(".tankstock-js-example-basic-multiple").select2({placeholder:{id:"-1",text:"Tag a tank or livestock"}});$(".cat-js-example-basic-multiple").select2({placeholder:{id:"-1",text:"Add a category to your post"}});$(".close-message-action").click(function(){closeGlobalMessage()});document.querySelector('div[contenteditable="true"]').addEventListener("paste",function(e){e.preventDefault();var a=e.clipboardData.getData("text/plain");document.execCommand("insertHTML",!1,a)});$("#datepicker-to").datepicker();$("#datepicker-from").datepicker();t=$(".mouse-tool-tip");$(".one-change").hover(function(){var e=$(this).attr("value");t.show();t.html(e)},function(){t.hide()});window.onmousemove=function(e){var a=$(".mouse-tool-tip"),t=e.clientX,n=e.clientY;a.css("top",n+20+"px");a.css("left",t+20+"px")};$(".day.one-change");$("#loginform #user_login").attr("placeholder","Username");$("#loginform #user_pass").attr("placeholder","Password");$(".menu-button").click(function(e){e.preventDefault();$(".menu-bar").toggleClass("open")});$(".journals-btn").click(function(){$("#journal-form").toggleClass("show");$(".menu-bar").toggleClass("extended");$(".overlay").fadeToggle()});$(".journals .close").click(function(){$(".journals.form-contain").fadeToggle();$(".overlay").fadeToggle()});$.fn.serializeObject=function(){var e={},a=this.serializeArray();$.each(a,function(){if(e[this.name]){e[this.name].push||(e[this.name]=[e[this.name]]);e[this.name].push(this.value||"")}else e[this.name]=this.value||""});return e};$("#ajax-form").submit(function(a){var t,n,o,r,i,s,l,c,d,u;a.preventDefault();t=$("#ajax-form").serializeObject();n=t["action"];o=t["tank_id"];r=t["type"];i=t["user_id"];s=t["type"];s="chart"+s;if($("#"+s).length&&"new_tank_params"==n){l=chartDataConstructor(t);c=l[0];d=l[1];u=l[2]}if(0==$(this).valid());else{$.post(ajaxurl,t,function(e){});if(t="0"){$(".overlay").fadeToggle();$(".menu-bar").toggleClass("extended");$(".form-contain").toggleClass("show")}else $(".form-contain").html("There was an error - please contact the administrator. Error 78");if($("#"+s).length&&"param_form"==n){addData(c,d,u);e(o,r,i)}}});$("#journal-img").on("change",function(){var e,a,t=this.value,n=t.lastIndexOf("\\");n>=0&&(t=t.substring(n+1));e=$("#journal-img")[0].files;for(a=0;a<e.length;a++){fileSize=e[a].size;if(fileSize>1e7){alert("You have exceeded the maximum file upload size for one or more of your images. Please correct this before submiting.");$("#journal-img").value=""}$("#post-images").html("");return!1}});$("#journal-form").submit(function(e){var a,t;e.preventDefault();a='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(a);t=new FormData(this);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:t,success:function(e){if("limit"==e){$(".global-error").html("You need to wait at least 60 seconds before posting again.");$(".global-error").fadeToggle();$(".global-error").delay(2e3).fadeToggle();$("#journal-form").toggleClass("show");$(".menu-bar").toggleClass("extended");$(".overlay").fadeToggle();$("#journal-form .status").html("What is goin on today?");$(".spinner-loader").remove()}else{$(".global-suc").html("Journal has been logged.");$(".global-suc").fadeToggle();$(".global-suc").delay(2e3).fadeToggle();$("#journal-form").toggleClass("show");$(".menu-bar").toggleClass("extended");$(".overlay").fadeToggle();$("#journal-form .status").html("What is goin on today?");$(".spinner-loader").remove();$("#journal-img").value="";$("#post-images").html("")}},error:function(e){}})});$("#j-status").focus(function(){$(this).find("i").remove()});$("#j-status").focusout(function(){var e=$(this).html();$("#status-content").attr("value",e)});$(".select_tank .fa-search").click(function(){var e=$(this).attr("tankid");$(".tank-menu a").each(function(){var a=$(this).attr("name"),t=a+"?tank_id="+e;$(this).attr("href",t)})});$(".select_tank .fa-flask").click(function(){var e=$(this).attr("tankid");$(".tank-menu a").each(function(){var a=$(this).attr("name"),t=a+"?tank_id="+e;$(this).attr("href",t)});window.location.href="/parameters?tank_id="+e});$("#export").click(function(e){var a,t,n;e.preventDefault();a=$(this).attr("param_type");t=$(this).attr("curuser");n=$(this).attr("tank_id");window.open("/export-param-table?tank_id="+n+"&curuser="+t+"&param_type="+a,"_blank")});$("#j-status").focus(function(){$(this).find("i").remove()});$("#j-status").focusout(function(){var e=$(this).html();$("#status-content").attr("value",e)});n=function e(a){var t=decodeURIComponent(window.location.search.substring(1)),n=t.split("&"),o,r;for(r=0;r<n.length;r++){o=n[r].split("=");if(o[0]===a)return void 0===o[1]||o[1]}};$(".wrap").on("click",".gallery-item",function(){var e=$(this).find("img").attr("full"),t='<div class="gallery-expanded"><div class="gal-close"><i class="fas fa-times-circle fa-lg"></i></div><img src="'+e+'"></div>';$(".overlay").show();$(".overlay").before(t);$(".menu-bar").css("top","-50px");a()});$(".wrap").on("click",".gal-close",function(){$(".overlay").hide();$(".gallery-expanded").remove();$(".menu-bar").css("top","0px");$(this).remove()});$(window).resize(function(){a()})});$(document).ready(function(){Object.entries=function(e){var a=Object.keys(e),t=a.length,n=new Array(t);while(t--)n[t]=[a[t],e[a[t]]];return n}});$(document).ready(function(){function e(){setTimeout(function(){location.reload()},500)}Object.entries=function(e){var a=Object.keys(e),t=a.length,n=new Array(t);while(t--)n[t]=[a[t],e[a[t]]];return n};$(".stock-next-step").click(function(){$("#livestock-form .step-one").fadeToggle("fast");$("#livestock-form .step-two").fadeToggle("slow")});$(".stock-prev-step").click(function(){$("#livestock-form .step-one").fadeToggle("slow");$("#livestock-form .step-two").fadeToggle("fast")});$(".stock-message-action").click(function(){var e=$(this).attr("stock_id"),a=$(this).attr("nonce");$(".global-message .message").text("Are you sure you want to delete this entry?");$(".confirmation-btn").attr("stock_id",e);$(".confirmation-btn").attr("nonce",a);$(".confirmation-btn").addClass("stock-confirmation-btn");$(".message-action").addClass("stock-message-action");$(".global-message").fadeToggle();$(".overlay").fadeToggle()});$(".global-message").on("click",".stock-confirmation-btn",function(){var a=$(this).attr("nonce"),t=$(this).attr("stock_id");data={action:"del_livestock",ajax_form_nonce_del_stock:a,stock_id:t};$.ajax({url:ajaxurl,method:"post",data:data,success:function(a){e()},error:function(e){}})});$("#stock_filter a").click(function(){var e,a,t;$(this).parent().find(".current").removeClass("current");$(this).addClass("current");e=$(this).attr("value");a=$(this).parent().attr("tank_id");t='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(t);data={action:"list_of_stock",tank_id:a,stock_type:e};$.ajax({url:ajaxurl,method:"post",data:data,success:function(e){$(".stock-list").html(e);$(".spinner-loader").remove()},error:function(e){}})});$(".add-livestock").click(function(){$(".add-livestock-form").toggleClass("extended");$(".overlay").fadeToggle();$(".menu-bar").toggleClass("extended-more")});$("#livestock-form").submit(function(a){var t,n,o;a.preventDefault();if($("#livestock-form .stock-name").val()){$(".global-error").removeClass("show");t=new FormData;n=$("#livestock-form").serializeArray();$.each(n,function(e,a){t.append(a.name,a.value)});o=$("#Livestock-output").attr("src");t.append("file",o);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:t,success:function(a){e()},error:function(e){}})}else{$(".global-error").html("Your livestock needs a name.");$(".global-error").addClass("show")}});$(".edit-stock").click(function(){var e=$(this).parent();if(e.find("li").hasClass("hide")){e.find("li.hide span").text("Edit Value");e.find("li.hide").addClass("new-value");e.find("li").removeClass("hide")}e.find("li span").attr("contenteditable","true");e.find("li span").toggleClass("tankEditable");$(this).hide();e.find(".save-tank-stock").removeClass("hide");e.find(".del-stock").removeClass("hide");e.find(".stock-update-img").removeClass("hide")});$(".save-tank-stock").click(function(){var a,t,n,o,r,i,s,l,c,d;$("li.new-value span").each(function(){"Edit Value"==$(this).text()&&$(this).text("")});a=$(this).attr("stock_id"),t=$(this).attr("nonce"),n=$(this).parent(),o=n.find(".name span").text(),r=n.find(".species span").text(),i=n.find(".age span").text(),s=n.find(".status span").text(),l=n.find(".sex span").text(),c=n.find(".count span").text();d='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(d);data={action:"update_user_stock",ajax_form_nonce_save_stock:t,stock_id:a,stock_name:o,stock_species:r,stock_age:i,stock_status:s,stock_sex:l,stock_count:c};$.ajax({url:ajaxurl,method:"post",data:data,success:function(a){e()},error:function(e){}})});$(".stock-photo-img").change(function(a){var t,n,o,r,i;a.preventDefault();t=$(this).parent().parent();n=new FormData;o='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(o);r=t.serializeArray();$.each(r,function(e,a){n.append(a.name,a.value)});i=t.find(".stock-photo-img")[0].files[0];n.append("file",i);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:n,success:function(a){e()},error:function(e){}})})});$(document).ready(function(){function e(){$(".frost").fadeOut();$(".step-three").delay(400).fadeIn();setTimeout(function(){window.location="/tanks/"},1500)}Object.entries=function(e){var a=Object.keys(e),t=a.length,n=new Array(t);while(t--)n[t]=[a[t],e[a[t]]];return n};$("#skip-add-tank").click(function(){e()});$(".add-tank").click(function(){$(".add-tank-form").toggleClass("extended");$(".overlay").fadeToggle();$(".menu-bar").toggleClass("extended-more")});$("#tank-form").submit(function(a){var t,n,o,r,i;a.preventDefault();if($("#tank-form .tank-name").val()){$(".global-error").removeClass("show");t=$("#regi-form .username").val();$("#tank-form .verfication").attr("value",t);n=new FormData;o=$("#tank-form").serializeArray();$.each(o,function(e,a){n.append(a.name,a.value)});r=$("#tank-img")[0].files[0];n.append("file",r);i='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(i);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:n,success:function(a){e()},error:function(e){}})}else{$(".global-error").html("Your tank needs a name.");$(".global-error").addClass("show")}});$(".global-message").on("click",".tank-confirmation-btn",function(){var e=$(this).attr("tank_id"),a=$(this).attr("nonce"),t=$(this).attr("parent").parent=$("."+t);data={action:"del_tank",ajax_form_nonce_del_tank:a,tank_id:e};$.ajax({url:ajaxurl,method:"post",data:data,success:function(e){$(".removeTank").remove();closeGlobalMessage()},error:function(e){}})});$(".wrap").on("click",".delete-tank",function(){var e=$(this).attr("tank_id"),a=$(this).attr("param_id"),t=$(this).attr("nonce");$(this).parent().parent().parent().addClass("removeTank");$(".global-message .message").text("Are you sure you want to delete this entry and all of it's associated data? This includes, images, posts, favs, parameters and livestock. This cannot be undone.");$(".confirmation-btn").attr("tank_id",e);$(".confirmation-btn").attr("nonce",t);$(".confirmation-btn").attr("parent",parent);$(".confirmation-btn").addClass("tank-confirmation-btn");$(".message-action").addClass("tank-message-action");$(".global-message").fadeToggle();$(".overlay").fadeToggle()});$(".edit-tank").click(function(){var e=$(this).parent().parent();if(e.find("span").hasClass("hide")){e.find("span.hide i").text("Edit Value");e.find("span.hide").addClass("new-value");e.find("span").removeClass("hide")}e.find(".tank_info").attr("contenteditable","true");e.find(".tank_info").toggleClass("tankEditable");$(this).hide();e.find(".save-edit-tank").show();e.find(".delete-tank").show();e.parent().find(".image-change").show()});$(".save-edit-tank").click(function(){var a=$(this).attr("tank_id"),t=$(this).attr("nonce"),n=$(this).parent().parent(),o=n.find(".tank_name").text(),r=n.find(".tank_volume").text(),i=n.find(".tank_dimensions").text(),s=n.find(".tank_model").text(),l=n.find(".tank_make").text();$(".overlay").after('<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>');data={action:"update_user_tank",ajax_form_nonce_update_tank:t,tank_id:a,tank_name:o,tank_volume:r,tank_dimensions:i,tank_model:s,tank_make:l};$.ajax({url:ajaxurl,method:"post",data:data,success:function(a){e()},error:function(e){}})});$(".tank-photo-img").change(function(a){var t,n,o,r,i;a.preventDefault();t=$(this).parent().parent();n=new FormData;o='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(o);r=t.serializeArray();$.each(r,function(e,a){n.append(a.name,a.value)});i=t.find(".tank-photo-img")[0].files[0];n.append("file",i);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:n,success:function(a){e()},error:function(e){}})})});$(document).ready(function(){$(".wrap").on("click",".post-options",function(){$(this).parent().find(".post-options-menu").fadeToggle()});$(".wrap").on("click",".report-this-post",function(){var e,a,t,n,o,r;$(this).parent().parent().remove();e=$(this).attr("post_id");a=$(this).attr("reporting_user");t=$(this).attr("auth_id");n=$(this).attr("report_nonce");o=$(this).attr("content_type");r={action:"mod_log",ref_id:e,content_type:o,reporting_user_id:a,author_id:t,report_ajax_nonce:n};$.ajax({url:ajaxurl,method:"post",data:r,success:function(e){$(".post-options-menu").hide();$(".global-suc").html("Thank you for your report.");$(".global-suc").fadeToggle();$(".global-suc").delay(2e3).fadeToggle()},error:function(e){}})});$(".wrap").on("click",".mod-tool-action",function(){var e=$(this).attr("report_id"),a=$(this).attr("nonce"),t=$(this).attr("name"),n={action:"update_mod_log",report_id:e,ajax_form_mod_log:a,mod_approval:t};$.ajax({url:ajaxurl,method:"post",data:n,success:function(e){location.reload()},error:function(e){}})});$(".save-user-post").click(function(){var e,a,t,n;event.preventDefault();e=$(this).attr("post_id");a=$(".the_post_content").html();t=$(this).attr("nonce");n={action:"update_user_post",ajax_form_nonce_save_post:t,post_id:e,the_post_content:a};$.ajax({url:ajaxurl,method:"post",data:n,success:function(e){URL=document.URL;URL=URL.replace("edit=yes","");window.location=URL},error:function(e){}})});$(".category-filter a").click(function(){var e,a=$(this).attr("value"),t={},n=location.search.substring(1),o=/([^&=]+)=([^&]*)/g;while(e=o.exec(n))t[decodeURIComponent(e[1])]=decodeURIComponent(e[2]);t["cats"]=a;location.search=$.param(t)});$(".wrap").on("click",".fave",function(e){var a,t,n,o,r;e.preventDefault();if($(this).hasClass("static")){a="un_favorite_post";$(this).removeClass("static")}else{a="favorite_post";$(this).addClass("static");$(this).html('<i class="fas fa-heart"></i> Faved')}t=$(this).attr("ref_id");n=$(this).attr("fav_ajax_nonce");o=$(this).attr("user");r={ref_id:t,user:o,action:a,fav_ajax_nonce:n};$.ajax({url:ajaxurl,method:"post",data:r,success:function(e){},error:function(e){}})})});$(document).ready(function(){function e(){var e,a=new Date,t=a.getFullYear(),n=a.getMonth()+1,o=a.getDate(),r=a.getMinutes(),i=a.getSeconds(),s=a.getHours();s>12?s-=12:0===s&&(s=12);1==n.toString().length&&(n="0"+n);1==o.toString().length&&(o="0"+o);1==s.toString().length&&(s="0"+s);1==r.toString().length&&(r="0"+r);1==i.toString().length&&(i="0"+i);e=t+"-"+n+"-"+o+" "+s+":"+r+":"+i;return e}$(".global-message").on("click",".param-confirmation-btn",function(){var e=$(this).attr("tank_id"),a=$(this).attr("param_id"),t=$(this).attr("nonce"),n=$(this).attr("parent").parent=$("."+n);data={action:"del_tank_params",ajax_form_nonce_del_param:t,tank_id:e,param_id:a};$.ajax({url:ajaxurl,method:"post",data:data,success:function(e){$(".removeParam").remove();closeGlobalMessage()},error:function(e){}})});var a=function e(a){var t=decodeURIComponent(window.location.search.substring(1)),n=t.split("&"),o,r;for(r=0;r<n.length;r++){o=n[r].split("=");if(o[0]===a)return void 0===o[1]||o[1]}};$(".param-filters").click(function(){var e,t,n,o,r;e=$("#datepicker-from").datepicker("option","dateFormat","yy-mm-dd").val();t=$("#datepicker-to").datepicker("option","dateFormat","yy-mm-dd").val();n=a("tank_id");o="/paramque?"+"tank_id="+n+"&date_start="+e+"&date_end="+t;r=$(this).attr("value");$.ajax({url:"/paramque?"+"tank_id="+n+"&date_start="+e+"&date_end="+t,success:function(e){$(".parameter_overview").html(e)}})});$(".param-table-filters").click(function(){var e=$("#datepicker-from").datepicker("option","dateFormat","yy-mm-dd").val(),t=$("#datepicker-to").datepicker("option","dateFormat","yy-mm-dd").val(),n=a("tank_id");$.ajax({url:"/paramtableque?"+"tank_id="+n+"&date_start="+e+"&date_end="+t,success:function(e){$(".params").html(e)}})});$(".wrap").on("click",".del-param-input",function(){var e=$(this).attr("tank_id"),a=$(this).attr("param_id"),t=$(this).attr("nonce");$(this).parent().parent().addClass("removeParam");$(".global-message .message").text("Are you sure you want to delete this entry?");$(".confirmation-btn").attr("param_id",a);$(".confirmation-btn").attr("tank_id",e);$(".confirmation-btn").attr("nonce",t);$(".confirmation-btn").attr("parent",parent);$(".confirmation-btn").addClass("param-confirmation-btn");$(".message-action").addClass("param-message-action");$(".global-message").fadeToggle();$(".overlay").fadeToggle()});$(".wrap").on("click",".edit-param-input",function(){var e=$(this).parent().parent();e.find(".param_value").attr("contenteditable","true");e.find(".param_value").addClass("editable");e.find(".save-btn").removeClass("hide");e.find(".edit-btn").addClass("hide");e.toggleClass("edited-row")});$(".wrap").on("click",".save-param-input",function(){var a=$(this).attr("tank_id"),t=$(this).attr("nonce"),n=$(this).attr("param_id"),o=$(this).parent().parent(),r=o.find(".param_type").val(),i=o.find(".param_value").val(),s=o.find(".param_value").text(),l=o.hasClass("edited-row"),c=0;if("Parameter"==r&&0==l){o.find(".param_type").parent().addClass("error-cell");c=0}else c++;if($.isNumeric(i)||0!=l)c++;else{o.find(".param_value").parent().addClass("error-cell");c=0}if(1==l){data={action:"save_tank_params",ajax_form_nonce_save_param:t,tank_id:a,param_id:n,value:s};o.find(".param_value").attr("contenteditable","false");o.find(".param_value").removeClass("editable");o.find(".save-btn").addClass("hide");o.find(".edit-btn").removeClass("hide");o.toggleClass("edited-row")}else data={action:"new_tank_params",ajax_form_nonce_save_param:t,tank_id:a,type:r,value:i};if(2!=c){$(".global-error").html("Please enter a parameter type and or correct parameter value.");$(".global-error").addClass("show");setTimeout(function(){$(".global-error").removeClass("show")},2e3)}else{o.find(".date_logged").html(e);o.find(".param_type").parent().removeClass("error-cell");o.find(".param_value").parent().removeClass("error-cell");$.ajax({url:ajaxurl,method:"post",data:data,success:function(e){var a,t;if("0"!=e){$(".new-input .save-btn a").attr("param_id",e);$(".new-input .edit-btn a").attr("param_id",e);$(".new-input .del-btn a").attr("param_id",e);a=$(".input-row").find(".param_value").val();$(".input-row").find(".param_value").parent().addClass("param_value");$(".input-row").find("input.param_value").remove();$(".input-row").find(".param_value").text(a);t=$(".input-row").find(".param_type").find("option:selected").attr("name");$(".input-row").find(".param_type").parent().addClass("param_type");$(".input-row").find("select.param_type").remove();$(".input-row").find(".param_type").text(t);$(".input-row").removeClass("new-input");$(".input-row").find(".save-btn").addClass("hide");$(".input-row").removeClass("input-row");$("tbody tr").first().next().before(inputRow)}},error:function(e){}})}})});$(document).ready(function(){function e(){$(".step-one").fadeOut();$(".frost").css({height:"570px"});$(".step-two").delay(400).fadeIn()}$.fn.serializeObject=function(){var e={},a=this.serializeArray();$.each(a,function(){if(e[this.name]){e[this.name].push||(e[this.name]=[e[this.name]]);e[this.name].push(this.value||"")}else e[this.name]=this.value||""});return e};$("#regi-form").submit(function(a){var t,n,o,r,i;a.preventDefault();t=$(".pass-2").val();n=$(".pass-1").val();o=$(".email").val();String.prototype.contains=function(e){return-1!=this.indexOf(e)};if(t==n&&"undefined"!=n&&null!=n)if(null!=o&&o.contains("@")){r=$(".tos-agreement:checkbox:checked").length>0;if(0!=r){i=$("#regi-form").serializeObject();$.post(ajaxurl,i,function(a){if("sucess"==a)e();else{$(".global-error").html(a);$(".global-error").addClass("show")}})}else{$(".global-error").html("You must read and agree to the Terms of Service");$(".global-error").addClass("show")}}else{$(".global-error").html("A valid Email is required.");$(".global-error").addClass("show")}});$("#regi-form .marketing-agreement").change(function(){$(this).val("no")});$("#regi-form .regi-validate").change(function(){var e,a,t=$(this).val(),n=$("#ajax_form_nonce").val();e=$(this).hasClass("username")?"user_nicename":"user_email";a={attribute:t,nonce:n,checker:e,action:"validate_regi_form"};$.post(ajaxurl,a,function(e){if(1==e){$("#regi-form .username").css({color:"#ff5050"});$("#regi-form .email").css({color:"#ff5050"});$(".global-error").html("Sorry about that, that username or email already exist.");$(".global-error").addClass("show")}else{$("#regi-form .username").css({color:"#fff"});$("#regi-form .email").css({color:"#fff"});$(".global-error").removeClass("show")}})});$("#regi-form .pass-2").keyup(function(){if($(this).val()==$(".pass-1").val()){$("#regi-form .pass-1").css({color:"#fff"});$("#regi-form .pass-2").css({color:"#fff"});$(".global-error").removeClass("show");$(".account-reg").css({opacity:"1"})}else{$(".account-reg").css({opacity:"0.3"});$("#regi-form .pass-1").css({color:"#ff5050"});$("#regi-form .pass-2").css({color:"#ff5050"});$(".global-error").html("Hmm, your passwords do not match, please fix that before we continue.");$(".global-error").addClass("show")}})});$(document).ready(function(){$("#trello-form").submit(function(e){var a,t,n;e.preventDefault();a=new FormData;t=$(this).serializeArray();$.each(t,function(e,t){a.append(t.name,t.value)});n='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(n);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:a,success:function(e){$(".spinner-loader").remove();$(".global-suc").html("Thank you for your report.");$(".global-suc").fadeToggle();$(".global-suc").delay(2e3).fadeToggle();setTimeout(function(){window.location="/tanks/"},2200)},error:function(e){}})})});$(document).ready(function(){Object.entries=function(e){var a=Object.keys(e),t=a.length,n=new Array(t);while(t--)n[t]=[a[t],e[a[t]]];return n};$.fn.serializeObject=function(){var e={},a=this.serializeArray();$.each(a,function(){if(e[this.name]){e[this.name].push||(e[this.name]=[e[this.name]]);e[this.name].push(this.value||"")}else e[this.name]=this.value||""});return e};$("#pass-reset-form").submit(function(e){var a,t,n;e.preventDefault();a=new FormData;t=$(this).serializeArray();$.each(t,function(e,t){a.append(t.name,t.value)});n='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(n);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:a,success:function(e){$(".spinner-loader").remove();$(".global-suc").html("An email has been sent to the provided email.");$(".global-suc").fadeToggle();$(".global-suc").delay(2e3).fadeToggle();setTimeout(function(){window.location="/user-login/"},2e3)},error:function(e){}})});$("#pass-reseting-form").submit(function(e){var a,t,n;e.preventDefault();a=new FormData;t=$(this).serializeArray();$.each(t,function(e,t){a.append(t.name,t.value)});n='<div class="ias-spinner-idea spinner-loader" style="text-align: center; position:fixed; top:25%; left:0; right:0; margin:0 auto; z-index:9999999999;"><img src="https://loading.io/spinners/gooeyring/index.gooey-ring-spinner.svg"/></div>';$(".overlay").after(n);$.ajax({url:ajaxurl,method:"post",processData:!1,contentType:!1,data:a,success:function(e){$(".spinner-loader").remove();$(".global-suc").html("Your password has been succesfully changed.");$(".global-suc").fadeToggle();$(".global-suc").delay(2e3).fadeToggle();setTimeout(function(){window.location="/user-login/"},2e3)},error:function(e){}})});$("#pass-reset-form .email-validate").keyup(function(){var e=$(this).val(),a=$("#ajax_form_nonce").val(),t="user_email",n={attribute:e,nonce:a,checker:t,action:"validate_regi_form"};e.indexOf("@")>=0&&$.post(ajaxurl,n,function(e){if(1==e){$(".btn.pass-reset").removeClass("hide");$(".bad-btn").hide();$(".global-error").removeClass("show")}else{$(".btn.pass-reset").addClass("hide");$(".bad-btn").show();$(".global-error").html("That email does not match our records.");$(".global-error").addClass("show")}})});$("#pass-reseting-form .pass-2").keyup(function(){var e=$(this).val(),a=$(".pass-1").val();if(e==a||a==e){$("#pass-reseting-form .pass-1").css({color:"#fff"});$("#pass-reseting-form .pass-2").css({color:"#fff"});$(".global-error").removeClass("show");$(".btn.pass-reset").removeClass("hide");$(".bad-btn").hide()}else{$("#pass-reseting-form .pass-1").css({color:"#ff5050"});$("#pass-reseting-form .pass-2").css({color:"#ff5050"});$(".global-error").html("Hmm, your passwords do not match, please fix that before we continue.");$(".global-error").addClass("show");$(".btn.pass-reset").addClass("hide");$(".bad-btn").show()}})});