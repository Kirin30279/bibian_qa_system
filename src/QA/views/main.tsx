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
    <a href="#" className="btn btn-primary" onClick={(e) => {
        e.preventDefault();
      }}>送出</a> <a href="#" className="btn btn-danger" onClick={(e) => {
        e.preventDefault();
      }}>取消</a>
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