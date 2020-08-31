+ 管理端

  |傳送方式|Api Url|
  |---|---|
  |POST||

  + login.php

    ##### Request
    |參數名稱|參數說明|必要|
    |---|---|---|
    |act|需求辨別值|v|
    |account|登入帳號|v|
    |passwd|登入密碼|v|

    ##### Response

    |參數名稱|參數說明|必要|
    |---|---|---|
    |status|登入是否成功|v|
    |message|若失敗，回傳錯誤說明|v|

  + index.php

    ##### Request
    |參數名稱|參數說明|必要|
    |---|---|---|
    |act|需求辨別值|v|
    |page|頁數|v|

    ##### Response
    |參數名稱|參數說明|必要|
    |---|---|---|
    |status|登入是否成功|v|
    |message|若失敗，回傳錯誤說明|v|
    |data|參考回傳data格式|v|

    \* 回傳data格式
    ```javascript
    [{
      orderID: "",
      otderType: "",
      nation: "",
      memberName: "",
      createdTime: "",
      status: ""
    }, ...]
    ```

  + detail.php

    ##### Request
    |參數名稱|參數說明|必要|
    |---|---|---|
    |act|需求辨別值|v|
    |oid|訂單編號|v|

    ##### Response
    |參數名稱|參數說明|必要|
    |---|---|---|
    |status|登入是否成功|v|
    |message|若失敗，回傳錯誤說明|v|
    |data|參考回傳data格式|v|

    \* 回傳data格式
    ```javascript
    {
      status: "", // 處理狀態
      isSend: "", // 是否要寄信
      items: [{
        name: "",
        createdTime: "",
        contents: "",
        files: "",
      }, ...]
    }
    ```
  
  + 新增寫入回覆api

    ##### Request
    |參數名稱|參數說明|必要|
    |---|---|---|
    |act|需求辨別值|v|
    |content|回覆內容|v|
    |issend|是否要發信|v|
    |status|處理狀態|v|

    ##### Response

    |參數名稱|參數說明|必要|
    |---|---|---|
    |status|登入是否成功|v|
    |message|若失敗，回傳錯誤說明|v|


+ 用戶端

  |傳送方式|Api Url|
  |---|---|
  |POST||

  + qa.php

    ##### Request
    |參數名稱|參數說明|必要|
    |---|---|---|
    |act|需求辨別值|v|
    |oid|訂單編號|v|
    |content|問題內容|v|
    |qafiles|問題附件|x|

    ##### Response