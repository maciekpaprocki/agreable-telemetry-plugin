window.$ = window.$ || jQuery || window.jQuery;

export class AgreableTelemetryPlugin {

    constructor() {
        let $links = $('#wp-admin-bar-promo-downloads');

        if ($links.length < 1) {
            return false;
        }

        // add sweet alert to page as it's not an npm package
        let saScript = document.createElement('script');
        saScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.js';
        let firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(saScript, firstScriptTag);
        let saStyle = document.createElement('link');
        saStyle.rel = 'stylesheet';
        saStyle.href = 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css';
        let firstStyleTag = document.getElementsByTagName('link')[0];
        firstStyleTag.parentNode.insertBefore(saStyle, firstStyleTag);

        $links.on('click', 'a', this.handleClick.bind(this));
    }

    handleClick(e) {
        e.preventDefault();

        $.ajax({
            url: e.currentTarget.href,
            success: data => {
                if (data.status === 200) {
                    // show success modal
                    this.showSuccessModal(data.data.password);
                } else {
                    // show error modal
                    this.showErrorModal();
                }
            },
            error: data =>  {
                console.log('error', data);
                // show error modal
                this.showErrorModal();
            }
        });
    }

    showSuccessModal(password) {
        sweetAlert('Your download request was successful!', 'You\'ll get and email to say it\'s ready.\nPlease make a note of this password as you\'ll need it to open the file:\n\n' + password, 'success');
    }

    showErrorModal() {
        sweetAlert('There was a problem with your download request!', 'Something went a bit wrong, but we\'re not sure what. Drop us an email at helpmeitbroke@telemetry.report and we\'ll take a look into it for you.', 'warning');
    }

};

window.onload = () => {
    // get shit started
    let exportPlugin = new AgreableTelemetryPlugin();
}
