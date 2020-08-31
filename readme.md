+ 測試帳號

  + 管理帳號
    bibianadmin@bibian.com / bibians12345

  + 客戶帳號
    bibianclient@bibian.com / bibianc12345

+ 管理端

  |傳送方式|Api Url|
  |---|---|
  |POST||

  + login.php

    ##### Request
    |參數名稱|參數說明|預設值|必要|
    |---|---|---|---|
    |act|需求辨別值|checkLogin|v|
    |account|登入帳號||v|
    |passwd|登入密碼||v|

    ##### Response

    |參數名稱|參數說明|必要|
    |---|---|---|
    |status|登入是否成功|v|
    |message|若失敗，回傳錯誤說明|v|

  + index.php

    ##### Request
    |參數名稱|參數說明|預設值|必要|
    |---|---|---|---|
    |act|需求辨別值|checkQAList|v|
    |page|頁數||v|

    ##### Response
    |參數名稱|參數說明|必要|
    |---|---|---|
    |status|登入是否成功|v|
    |message|若失敗，回傳錯誤說明|v|
    |data|參考回傳data格式|v|

    \* 回傳data格式
    ```javascript
    [{
      orderID: "", // 訂單編號
      otderType: "", // 訂單類型（代購單還是代標單)
      nation: "", // 國別
      memberName: "", // 發問會員名稱
      createdTime: "", // 發問日期
      qaStatus: "" // 處理狀態
    }, ...]
    ```

  + detail.php

    ##### Request
    |參數名稱|參數說明|預設值|必要|
    |---|---|---|---|
    |act|需求辨別值|checkQADetail|v|
    |oid|訂單編號||v|

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
        name: "", // 會員/專員名稱
        createdTime: "", // 問題/回應時間
        contents: "", // 問題/回應內容
        files: "", // 問題/回應附件
      }, ...]
    }
    ```
  
  + 新增寫入回覆api

    ##### Request
    |參數名稱|參數說明|預設值|必要|
    |---|---|---|---|
    |act|需求辨別值|checkUpdateQASContent|v|
    |qaContent|回覆內容||v|
    |isSend|是否要發信||v|
    |qaStatus|處理狀態||v|

    ##### Response

    |參數名稱|參數說明|必要|
    |---|---|---|
    |status|登入是否成功|v|
    |message|若失敗，回傳錯誤說明|v|

  + 新增圖片上傳api

    ##### Request
    |參數名稱|參數說明|預設值|必要|
    |---|---|---|---|
    |act|需求辨別值|checkUpdateQAFiles|v|
    |upload|上傳內容||v|

    ##### Response

    |參數名稱|參數說明|必要|
    |---|---|---|
    |status|登入是否成功|v|
    |message|若失敗，回傳錯誤說明|v|
    |data|參考回傳data格式|v|

    \* 回傳data格式
    ```javascript
    {
      data: "", // 檔案路徑
      name: "", // 檔案名稱,
      type: "", // 檔案類型
      error: "" // 錯誤訊息
    }
    ```


+ 用戶端

  |傳送方式|Api Url|
  |---|---|
  |POST||

  + qa.php

    ##### Request
    |參數名稱|參數說明|預設值|必要|
    |---|---|---|---|
    |act|需求辨別值|checkUpdateQACContent|v|
    |oid|訂單編號||v|
    |qaContent|問題內容||v|
    |qaFiles|問題附件||x|

    ##### Response

    |參數名稱|參數說明|必要|
    |---|---|---|
    |status|登入是否成功|v|
    |message|若失敗，回傳錯誤說明|v|