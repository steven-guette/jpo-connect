async function fetchRequest(url, options = {}, format = null) {
    let response;
    try {
        response = await fetch(url, {
            ...options,
            credentials: 'include'
        });
    } catch (err) {
        console.error(`[HttpClient] ~ ${options.method || 'GET'} ${url} ~ Erreur de connexion à l'API :`, err);
        return {
            success: false,
            message: 'Une erreur est survenue lors du traitement de votre demande.',
            error: null,
            status: 500
        };
    }

    let data;
    try {
        switch (format) {
            case 'text':
                data = await response.text();
                break;
            case 'json':
                data = await response.json();
                break;
            case 'formData':
                data = await response.formData();
                break;
            case 'blob':
                data = await response.blob();
                break;
            case 'arrayBuffer':
                data = await response.arrayBuffer();
                break;
            default:
                throw new Error("Le format n'est pas pris en charge.");
        }
    } catch (err) {
        console.warn(`[HttpClient] ~ ${format} format ~ Impossible de formater les données depuis ${url}`, err)
        return {
            success: false,
            message: "Impossible de traiter la réponse du serveur.",
            error: err,
            status: response.status
        };
    }

    return data;
}

function get(url, resultFormat = 'json') {
    return fetchRequest(url, { method: 'GET' }, resultFormat);
}

function remove(url, resultFormat = 'json') {
    return fetchRequest(url, { method: 'DELETE' }, resultFormat);
}

function post(url, data, resultFormat = 'json') {
    return fetchRequest(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    },resultFormat)
}

function put(url, data, resultFormat = 'json') {
    return fetchRequest(url, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    }, resultFormat);
}

function patch(url, data, resultFormat = 'json') {
    return fetchRequest(url, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    }, resultFormat);
}

const HttpClient = { get, post, put, patch, remove };
export default HttpClient;