export default class AgreableTelemetryDataExport {

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
                // show error modal
                this.showErrorModal();
            }
        });
    }

    showSuccessModal(password) {
        sweetAlert({
            title: '<span style="color:#000">Your download request was successful!</span>',
            text: '<p style="color:#000">You\'ll get an email to say it\'s ready. Please make a note of this password as you\'ll need it to open the file:</p><p style="margin-top:20px;color:#000">' + password + '</p>',
            html: true,
            type: 'success'
        });
    }

    showErrorModal() {
        sweetAlert({
            title: '<span style="color:#000">There was a problem with your download request!</span>',
            text: '<span style="color:#000">Something went a bit wrong, but we\'re not sure what. Drop us an email at <a href="mailto:jon.sherrard@shortlist.com">jon.sherrard@shortlist.com</a> and we\'ll take a look into it for you.</span>',
            html: true,
            type: 'warning'
        });
    }

};
