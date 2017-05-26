# CK-Online Judge

[線上演示](http://140.116.245.156/9595/ojs/problemSet.php)

一個線上程式批改系統，目前簡要的實現了會員系統，編譯/執行 C 與 C++ 程式的功能。

## 專案資源

* 沙盒採用了[EasySandbox](https://github.com/daveho/EasySandbox)
* 測試題目集來自 [UVA](https://uva.onlinejudge.org/) 與 [POJ](http://poj.org/)。

## 搭建環境

* Ubuntu 14.04 與 Linux Mint Cinnamon 皆可正常運作
* 伺服端須搭載 PHP、MySQL 與 Apache
* 沙盒端要求配置好 GNU C
  * 可以透過 `make runtests` 測試 [EasySandbox](https://github.com/daveho/EasySandbox) 是否正常運作
  
## 注意事項

* 受限於資源需求，目前線上演示中的自動判題端為關閉狀態 (提交後為 PENDING )。

### 為什麼很容易爆炸?

* 目前判題僅支援 C/C++，其他語言會直接 Wrong Answer
* 程式的限制運行時間為 30 秒，超過會直接 Wrong Answer
* 預設每個答案最後都必須接上一個 `\n`，若找不到一樣會 Wrong Answer
