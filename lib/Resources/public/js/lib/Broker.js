ag.ns("ag.common");

(function(){

var broker = function() { };

broker.prototype.pub = function(eventName)
{
    var
        subscriptions = this.subscriptions,
        eventArgs = Array.prototype.slice.call(arguments, 1);

    if (subscriptions[eventName])
        subscriptions[eventName].forEach(function(callback){
            callback.apply(null, eventArgs);
        });

    return this;
};

broker.prototype.sub = function(eventNames, callback)
{
    var subscriptions = this.subscriptions;

    eventNames.split(/\s+/).forEach(function(eventName){
        if (!subscriptions[eventName])
            subscriptions[eventName] = [];

        subscriptions[eventName].push(callback);
    });

    return this;
};

broker.prototype.count = function(eventName)
{
    return this.subscriptions[eventName] ? this.subscriptions[eventName].length : 0;
};

broker.prototype.subscriptions = {};

ag.common.Broker = broker;

ag.srv("broker", new broker());

})();
