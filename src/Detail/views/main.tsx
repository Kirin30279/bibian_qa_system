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
    <div className="qaMsg card mb-2">
      <div className="card-body">
        <ClientItem {...props} />
        <ServiceItem {...props} />
      </div>
    </div>
  );
}

const ClientItem = (props: any) => {
  return (
    <div className="d-flex my-3">
      <div className="d-flex flex-column">
        <div className="d-flex align-items-end border-bottom">
          <div className="mr-3">
            ListChen
          </div>
          <small className="text-muted">
            2020-07-01 10:00:00
          </small>
        </div>
        <div style={{ "width": "50rem" }}>
          <p>測試留言測試留言測試留言測試留言測試留言測試留言測試留言測試留言測試留言測試留言測試留言測試留言測試留言測試留言測試留言測試留言</p><p><img src="images/desktop_image.png" /></p>
        </div>
      </div>
    </div>
  );
}

const ServiceItem = (props: any) => {
  return (
    <div className="d-flex justify-content-end my-3">
      <div className="d-flex flex-column">
        <div className="d-flex justify-content-end align-items-end border-bottom">
          <div className="mr-3">
            YaoChing
          </div>
          <small className="text-muted">
            2020-07-01 10:19:00
          </small>
        </div>
        <div className="d-flex justify-content-end" style={{ "width": "50rem" }}>
          <p>測試回覆測試回覆測試回覆測試測試回覆測試回覆測試回覆測試回覆測試回覆測試回覆測試測試回覆測試回覆測試回覆測試回覆測試回覆測試回覆</p>
        </div>
      </div>
    </div>
  );
}

const MsgCallback = (props: any) => {
  React.useEffect(() => {
    (window as any).CKEDITOR.replace('editor', {
      toolbar: [
      { name: 'styles', items: [ 'Format', 'FontSize' ] },
      { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
      { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo' ] },
      { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', ] },
      { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
      { name: 'links', items: [ 'Link', 'Unlink' ] },
      { name: 'insert', items: [ 'Image', 'Iframe', 'Table' ] },
      { name: 'document', items: [ 'Source' ] }
      ],
      filebrowserImageUploadUrl: '/api/ckeditor_images_file?channel=news',
    });
    (window as any).CKEDITOR.config.removeDialogTabs = 'image:advanced;link:advanced';
  }, []);

  return (
    <>
    <div id="editor"></div>
    <div className="d-flex">
      <div className="col-6 p-0 d-flex my-1">
        <label className="mr-3">寄信</label>
        <div className="">
          <div className="form-check form-check-inline">
            <input className="form-check-input" type="radio" name="isSendEmail" value="Y" checked/>
            <label className="form-check-label">是</label>
          </div>
          <div className="form-check form-check-inline">
            <input className="form-check-input" type="radio" name="isSendEmail" value="N"/>
            <label className="form-check-label">否</label>
          </div>
        </div>
      </div>
      <div className="col-6 p-0 d-flex my-1 justify-content-end">
        <div className="mx-1">
          <a href="#" className="btn btn-primary btn-sm">回覆</a>
        </div>
        <div>
          <a href="#" className="btn btn-danger btn-sm">清除</a>
        </div>
      </div>
    </div>
    </>
  );
}

export default (props: any) => {
  return (
    <div className="m-2">
      <HocBreadcrumb {...props} />
      <HocDetail {...props} />
      <MsgCallback {...props} />
    </div>
  );
}