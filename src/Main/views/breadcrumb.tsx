import React from "react";

export default (props: any) => {
  return (
    <nav>
      <ol className="breadcrumb">
        {props.items.map((value: any) => {
          return (
            <li className={"breadcrumb-item " + ((value.isActive) ? "active" : "")}>{value.name}</li>
          )
        })}
      </ol>
    </nav>
  );
}