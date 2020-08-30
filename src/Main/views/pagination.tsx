import React from "react";

export default (props: any) => {
  return (
    <div className="d-flex justify-content-end my-3  align-items-center">
      <a className="mx-2" href="#" onClick={(e) => {
        e.preventDefault();
      }}>
        <div className="d-flex justify-content-center align-items-center" style={{ width: 18, height: 18 }}>
          <img src="images/back.png" width="18" />
        </div>
      </a>
      <a className="mx-2" href="#" onClick={(e) => {
        e.preventDefault();
      }}>
        <div className="d-flex justify-content-center align-items-center" style={{ width: 18, height: 18 }}>
          <img src="images/next.png" width="18" />
        </div>
      </a>
    <div className="mx-2">{(props.nowPage - 1) * 50}-{((props.nowPage - 1) * 50) + 50} of {props.totalPage * 50}</div>
    </div>
  );
}