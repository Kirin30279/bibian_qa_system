import React from "react";

import Breadcrumb from "./breadcrumb";
import Pagination from "./pagination";


// 麵包屑區塊
const HocBreadcrumb = (props: any) => {
  const [scope, setScope] = React.useState(<></>);

  React.useEffect(() => {
    let temp = [{
      name: "系統後台",
      isActive: false,
      url: ""
    }, {
      name: "問題列表",
      isActive: true,
      url: ""
    }];

    setScope(<Breadcrumb items={temp} {...props} />)
  }, []);

  return scope;
}

// 問題列表區塊
const HocList = (props: any) => {
  return (
    <table className="table table-bordered">
      <thead>
        <tr>
          <td>#</td>
          <td>訂單編號</td>
          <td>訂單類型</td>
          <td>國別</td>
          <td>會員名稱</td>
          <td>提問時間</td>
          <td>處理狀態</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>
            <a href="#" onClick={(e) => {
              e.preventDefault();
            }}>
              1234567890
            </a>
          </td>
          <td>標單</td>
          <td>日本</td>
          <td>ListChen</td>
          <td>2020-07-01 10:19:00</td>
          <td>已解決</td>
        </tr>
      </tbody>
    </table>
  );
}

// 分頁區塊
const HocPagination = (props: any) => {
  const [nowPage, setNowPage] = React.useState(1);
  const [totalPage, setTotalPage] = React.useState(1);

  return <Pagination nowPage={nowPage} totalPage={totalPage} {...props} />
}

export default (props: any) => {
  return (
    <div className="m-2">
      <HocBreadcrumb {...props} />
      <HocList {...props} />
      <HocPagination {...props} />
    </div>
  );
}