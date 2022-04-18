import {navigate} from "svelte-navigator";

function createQueryParametersUtil() {
    return {
        get() {
            return this.parse(window.location.search)
        },
        parseUrl(input="") {
            const i = input.split('?')
            return this.parse(i[1])
        },
        parse(input) {
            const params = new URLSearchParams(input);

            const paramsObj = Array.from(params.keys()).reduce(
                (acc, val) => ({...acc, [val]: params.get(val)}),
                {}
            );
            return paramsObj
        },
        stringify(params) {
            return new URLSearchParams(params).toString()
        }
        ,
        navigate(params) {
            navigate("?" + this.stringify(params))

        }
    };
}

export const queryParameters = createQueryParametersUtil();