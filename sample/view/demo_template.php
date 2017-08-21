<!--
    Tencent is pleased to support the open source community by making VasSonic available.
    Copyright (C) 2017 THL A29 Limited, a Tencent company. All rights reserved.
    Licensed under the BSD 3-Clause License (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at
    https://opensource.org/licenses/BSD-3-Clause
    Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sonic Demo</title>
    <script>
        window.onerror = function(err) {}
        // 引入js与oc交互的中间件JSBridge
        function setupWebViewJavascriptBridge(callback) {
            if (window.WebViewJavascriptBridge) { return callback(WebViewJavascriptBridge); }
            if (window.WVJBCallbacks) { return window.WVJBCallbacks.push(callback); }
            window.WVJBCallbacks = [callback];
            var WVJBIframe = document.createElement('iframe');
            WVJBIframe.style.display = 'none';
            WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';
            document.documentElement.appendChild(WVJBIframe);
            setTimeout(function() { document.documentElement.removeChild(WVJBIframe) }, 0)
        }
    </script>
</head>
<body>
<div class="sonic-wrapper">
    <h1>Sonic：轻量级的高性能的Hybrid框架</h1>
    <p>Sonic是腾讯QQ会员团队研发的一个轻量级的高性能的Hybrid框架，专注于提升H5页面首屏加载速度，让H5页面的体验更加接近原生，提升用户体验及用户留存率。</p>
    <span id="data1Content">
    <!-- 模拟数据更新 -->
    <!--sonicdiff-data1-->
    <h2>当前时间：<?php echo time().'' ?></h2>
    <!--sonicdiff-data1-end-->
    </span>
    <?php if($templateFlag){?>
    <p>以手机QQ-VIP中心首页为例，在接入Sonic框架之后，页面打开速度在数据更新场景下优化提升42%，页面内容不变的场景下(完全cache模式)优化提升50%以上。</p>
    <?php }?>
</div>
<script type="text/javascript">
    setupWebViewJavascriptBridge(function(bridge) {
        //注册getDiffDataCallback方法给客户端调用，从客户端接收diff数据
        //diffData是一个字符串，可从iOS客户端查看
        bridge.registerHandler('getDiffDataCallback', function(diffData, responseCallback) {
            //只有code为200时（数据更新）才进行局部刷新，其他状态客户端已处理
            try{var result = JSON.parse(diffData);} catch (e) {}
            //sonic状态 0-状态获取失败 1-sonic首次 2-页面刷新 3-局部刷新 4-完全cache
            if(result['code'] == 200){//局部刷新
                var sonicUpdateData = JSON.parse(result['result']);
                //局部刷新的时候需要更新页面的数据块和一些JS操作
                var html = '';
                var id = '';
                var elementObj = '';
                for(var key in sonicUpdateData){
                    id = key.substring(1,key.length-1);
                    html = sonicUpdateData[key];
                    elementObj = document.getElementById(id+'Content');
                    elementObj.innerHTML = html;
                }
            }
        })
        //主动调起客户端getDiffData方法，让客户端得到diff数据返回到本前端
        bridge.callHandler('getDiffData')
    })
</script>
</body>
</html>