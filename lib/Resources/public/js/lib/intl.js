ag.ns("ag.intl");

(function(){

var
    catalogs = {},
    curLoc = ag.cfg.locale,
    curLang = curLoc.substr(0, 2),
    pluralCallbacks = {},

    getEntry = function(msgid)
    {
        return catalogs[curLoc] ? catalogs[curLoc][msgid] : undefined;
    },

    getPluralMessageIdx = function(amount)
    {
        if (!pluralCallbacks[curLang])
            pluralCallbacks[curLang] = new Function("n", "return (" +  (ag.intl.plurals[curLang] || ag.intl.plurals["_default"]) + ") | 0");

        return pluralCallbacks[curLang](amount);
    };

ag.intl = ag.intl || {};

ag.intl.t = function(msgid)
{
    return getEntry(msgid) || msgid;
};

ag.intl.x = function(context, msgid)
{
    return getEntry(context + "\u0004" + msgid) || msgid;
};

ag.intl.n = function(msgid, msgidPlural, amount)
{
    var entry = getEntry(msgid);
    return entry ? entry[getPluralMessageIdx(amount)] : msgidPlural;
};

ag.intl.register = function(locale, catalog)
{
    if (!catalogs[locale])
        catalogs[locale] = {};

    Object.keys(catalog).forEach(function(msgid){
        catalogs[locale][msgid] = catalog[msgid];
    });
};

})();
