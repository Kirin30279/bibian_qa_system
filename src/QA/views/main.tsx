import React from "react";

import Breadcrumb from "../../Main/views/breadcrumb";

const HocBreadcrumb = (props: any) => {
  const [scope, setScope] = React.useState(<></>);

  React.useEffect(() => {
    let temp = [{
      name: "Bibian網站",
      isActive: false,
      url: ""
    }, {
      name: "客戶問題",
      isActive: true,
      url: ""
    }];

    setScope(<Breadcrumb items={temp} {...props} />)
  }, []);

  return scope;
}

const HocQA = (props: any) => {
  return (
    <>
    <div className="form-group">
      <label>訂單編號</label>
      <input type="text" className="form-control" />
    </div>
    <div className="form-group">
      <label>問題內容</label>
      <textarea className="form-control" cols={30}></textarea>
    </div>
    <div className="form-group">
      <label>問題附件</label>
      <input type="file" className="form-control" />
    </div>
    <a href="javascript:;" className="btn btn-primary">送出</a> <a href="javascript:;" className="btn btn-danger">取消</a>
    </>
  );
}

export default (props: any) => {
  return (
    <div className="m-2">
      <HocBreadcrumb {...props} />
      <HocQA {...props} />
    </div>
  );
}