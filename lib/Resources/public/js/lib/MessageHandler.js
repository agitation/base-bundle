ag.ns("ag.common");

(function(){
    var msgH = function() { };

    msgH.prototype.clear = function(/* category */) { };

    msgH.prototype.alert = function(text, type, category, closeCallback)
    {
        this.clear(category);
        window.alert(text);
        closeCallback && closeCallback();
    };

    msgH.prototype.confirm = function(question, yesCallback, noCallback)
    {
        if (window.confirm(question))
            yesCallback();
        else
            noCallback();
    };

    msgH.prototype.prompt = function(question, resultCallback)
    {
        resultCallback(window.prompt(question));
    };

    ag.common.MessageHandler = msgH;
})();
