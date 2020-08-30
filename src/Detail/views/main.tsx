import React from "react";

import Breadcrumb from "../../Main/views/breadcrumb";

const HocBreadcrumb = (props: any) => {
  const [scope, setScope] = React.useState(<></>);

  React.useEffect(() => {
    let temp = [{
      name: "系統後台",
      isActive: false,
      url: ""
    }, {
      name: "問題對話頁",
      isActive: true,
      url: ""
    }];

    setScope(<Breadcrumb items={temp} {...props} />)
  }, []);

  return scope;
}

const HocDetail = (props: any) => {
  return (
    <div>
      問題對話頁
    </div>
  );
}

export default (props: any) => {
  return (
    <div className="m-2">
      <HocBreadcrumb {...props} />
      <HocDetail {...props} />
    </div>
  );
}