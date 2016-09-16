ag.ns("ag.common");

(function(){
var pubSub = function() { };

pubSub.prototype = function() {};

pubSub.prototype.pub = function(eventName)
{
    var subscriptions = this.subscriptions;

    var eventArgs = Array.prototype.slice.call(arguments, 1);

    if (subscriptions[eventName])
        subscriptions[eventName].forEach(function(callback){
            callback.apply(null, eventArgs);
        });
};

pubSub.prototype.sub = function(eventName, callback)
{
    if (!this.subscriptions[eventName])
        this.subscriptions[eventName] = [];

    this.subscriptions[eventName].push(callback);
};

pubSub.prototype.subscriptions = {};

ag.common.PubSub = pubSub;
})();
