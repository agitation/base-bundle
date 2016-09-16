ag.ns("ag.common");

(function(){
    var msgH = function() { };

    msgH.prototype.clear = function(category) { };

    msgH.prototype.showMessage = function(message)
    {
        alert(message.getText());
    };

    msgH.prototype.alert = function(text, type, category)
    {
        this.clear(category);
        this.showMessage(new ag.common.Message(text, type || "error", category));
    };

    ag.common.MessageHandler = msgH;
})();
