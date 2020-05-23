class Lang {
    locales = {};

    constructor(locales) {
        this.locales = locales;
    }

    get(symbol) {
        return this.locales[symbol];
    }
}