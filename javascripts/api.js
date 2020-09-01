/*!
 * Matomo - Web Analytics
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

var LiveTabApi = LiveTabApi || (function () {

    function getSettings(onSuccess)
    {
        var ajaxRequest = new ajaxHelper();
        ajaxRequest.addParams({
            module: 'API',
            method: 'LiveTab.getSettings',
            format: 'JSON'
        }, 'get');
        ajaxRequest.useCallbackInCaseOfError();
        ajaxRequest.setErrorCallback(function () {});
        ajaxRequest.setCallback(
            function (response) {
                if (!response || typeof response != 'object') {

                    return;
                }

                onSuccess(response);
            }
        );
        ajaxRequest.send(false);
    }

    return {getSettings: getSettings};
})();
