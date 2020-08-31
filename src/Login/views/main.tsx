import React from "react";

export default (props: any) => {
  return (
    <form className="form-signin">
      <h1 className="h3 mb-3 font-weight-normal">QA管理系統</h1>
      <input type="email" className="form-control" placeholder="登入帳號" />
      <input type="password" className="form-control" placeholder="登入密碼" />
      <button type="button" className="btn btn-primary btn-lg btn-block">登入</button>
      <button type="button" className="btn btn-danger btn-lg btn-block">取消</button>
    </form>
  );
}