<?php
/**
 * Tencent is pleased to support the open source community by making VasSonic available.
 * Copyright (C) 2017 THL A29 Limited, a Tencent company. All rights reserved.
 * Licensed under the BSD 3-Clause License (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at
 * https://opensource.org/licenses/BSD-3-Clause
 * Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
 */
 //模拟耗时操作 
sleep(1.5);
//引入SonicSDK
require_once 'util/sonic.php';
//每次重新打开此界面都改变此值，模拟模版变化
$templateFlag = $_COOKIE['templateFlag'];
//模拟模版更新
// setcookie('templateFlag',!$templateFlag);
//启动Sonic
util_sonic::start();
//引入支持Sonic规范的模版
require 'view/demo_template.php';
util_sonic::end();