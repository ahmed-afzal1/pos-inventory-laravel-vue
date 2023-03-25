class Notification{
    success(){
        new Noty({
            type: 'success',
            text: 'Successfully Done!',
            layout: 'topRight',
            timeout: 1000,
            progressBar: true
        }).show();
    }

    alert(){
        new Noty({
            type: 'alert',
            text: 'Are you sure?',
            layout: 'topRight',
            timeout: 1000,
            progressBar: true
        }).show();
    }

    error(){
        new Noty({
            type: 'error',
            text: 'Something goes wrong!',
            layout: 'topRight',
            timeout: 1000,
            progressBar: true
        }).show();
    }

    warning(){
        new Noty({
            type: 'warning',
            text: 'Ops! Wrong',
            layout: 'topRight',
            timeout: 1000,
            progressBar: true
        }).show();
    }
}

export default Notification = new Notification();