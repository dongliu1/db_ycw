/**
 * Created by liudong on 2017/11/21.
 */
/**
 * 图片上传插件
 * $(selector).roxUpload({
 * success:function(data){},     //上传成功
 * failed:function(data){}       //上传失败
 * })
 */
(function ($) {																//闭包限定命名空间
    $.fn.roxUpload = function(){
        var data;
        if(arguments.length === 0 || typeof arguments[0] === 'object'){
            var option = arguments[0]
                , options = $.extend(true, {}, $.fn.roxUpload.defaults, option);
            data = this.data('roxUpload');
            if (!data) {
                data = new upload(this[0], options);
                data._init();
                this.data('roxUpload', data);
            }
            return $.extend(true, this, data);
        }
        if(typeof arguments[0] === 'string'){
            data = this.data('roxUpload');
            if($.isPlainObject(arguments[1])){
                $.extend(data.default,arguments[1]);
            }
            var fn =  data["_"+arguments[0]];
            if(fn){
                if(arguments[2])arguments[2](fn);
                var args = Array.prototype.slice.call(arguments);
                return fn.apply(data,args.slice(1));
            }
        }

    };

    $.fn.roxUpload.defaults = {
        filename:"",                                                            //文件名
        message:"",                                                             //图片信息
        filetype:"",                                                            //图片类型
        filesize:"",                                                            //图片尺寸
        errorInfo:{error:"请先选择一张图片"},                                   //错误信息
        success:function(data){},                                              //上传成功
        failed:function(data){},                                               //上传失败
    };

    var upload=function (element,opt) {
        this.$scope=$(element);
        this.default=opt;
    };

    upload.prototype={
        _init:function () {
            var _this=this.$scope;
            var _html=this._get_htmlCss();
                _html+= '<div class="rox-upload">';
                _html+= '   <input type="file" name="file" class="rox-fileImage" />';
                _html+= '   <img src="#" class="rox-image-thumb" alt="选择图片"/><br/>';
                _html+= '   <input type="button" name="rox-uploadButton" class="rox-uploadButton" value="上传" />';
                _html+= '</div>';
            $(_this).html(_html);
            this._bindChange();
            this._bindClick();
        },
        _get_htmlCss:function () {
            var _style="";
            _style+="<style>.rox-upload{width:155px;height:180px;position: relative;}";
            _style+=".rox-upload>img{background:#94c3c5;position:absolute;top:0;left:0;width:150px;height:150px;line-height:150px;text-align:center;}";
            _style+=".rox-upload>input[type='file']{position:absolute;left:0;top:0;cursor:pointer;width:150px;height:150px;z-index: 1000;opacity:0;filter:alpha(opacity=0);}";
            _style+=".rox-upload>input.rox-uploadButton{position:absolute;top:155px;left:0;width:70px;height:30px;background:#2977bb;color:#fff;border:0;border-radius:5px;padding:5px 10px;}</style>";
            return _style;
        },
        _bindChange:function () {
            var _this=this.$scope;
            var that=this;
            $(".rox-fileImage",_this).bind("change",function (e) {
                //console.log("aaaaa",e)
                var objUrl = that._getObjectURL(this.files[0]) ; //获取图片的路径，该路径不是图片在本地的路径
                //console.log(objUrl);
                if (objUrl) {
                    $('.rox-image-thumb',_this).attr('src', objUrl);     //开始上传之前，预览图片
                }
            })
        },
        _getObjectURL:function (file) {
            var url = null ;
            if (window.createObjectURL!=undefined) { // basic
                url = window.createObjectURL(file) ;
            } else if (window.URL!=undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file) ;
            } else if (window.webkitURL!=undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file) ;
            }
            return url ;
        },
        _bindClick:function () {
            var _this=this.$scope;
            var opt=this.default;
            var _self=this;
            $(".rox-uploadButton",_this).off("click").on("click",function(){
                var filetype = ['jpg','jpeg','png','gif'];          //定义允许上传的图片格式，不合法的格式将不会上传
                var files=$('.rox-fileImage',_this).get(0).files;
                if(files&&files.length) {
                    var fi = files[0];                              //得到文件信息
                    console.log(fi);
                    var fname = fi.name.split('.');                 //文件名
                    if (filetype.indexOf(fname[1].toLowerCase()) == -1) {   //判断文件格式是否是图片 如果不是图片则返回false
                        return opt.failed({error:"文件格式错误,只允许上传jpg、jpeg、png、gif格式图片"});
                    }
                    opt.filename=fname[0];
                    opt.filetype=fname[1];
                    opt.filesize=fi.size;
                    _self._init_onload(fi)
                }else{
                    opt.failed(opt.errorInfo);
                }
            });
        },
        _init_onload:function (fi) {
            var opt=this.default;
            var that=this.$scope;

            var fr = new FileReader();                  //实例化h5的fileReader
            fr.readAsDataURL(fi);                        //以base64编码格式读取图片文件
            fr.onload = function (frev) {
                opt.message = frev.target.result;           //得到结果数据
                //$('.rox-image-thumb',_this).attr('src', opt.message);     //开始上传之前，预览图片

                var fileInfo={
                    "message" : opt.message,
                    "filename": opt.filename,
                    "filetype": opt.filetype,
                    "filesize": opt.filesize
                };
                //使用ajax 利用post方式提交数据
                requestApi.uploadImg(fileInfo).then(function (data) {
                    data=eval("("+data+")");
                    if (data.code==1) {
                        delete data.code;
                        var file = $(".rox-fileImage",that);
                        file.after(file.clone().val(""));
                        file.remove();
                        opt.errorInfo={error:"图片已上传，请重新选择一张图片",data:data};
                        opt.success({success:"上传成功",data:data})
                    } else{
                        opt.failed({error:"上传失败"});
                    }
                });
            }
        }
    }
})(window.jQuery);