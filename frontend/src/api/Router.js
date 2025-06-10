import HttpClient from './HttpClient'
import { ROUTER_PATH } from '../config/api/router.js'

export default function Router(route) {
    const fullURL = getFullURL(route);

    async function getOne(id) {
        return await HttpClient.get(`${fullURL}/${id}`);
    }

    async function getAll(filters = {}) {
        return await HttpClient.get(`${fullURL}${URIBuilder(filters)}`);
    }

    async function post(data) {
        return await HttpClient.post(fullURL, data);
    }

    async function put(id, data) {
        return await HttpClient.put(`${fullURL}`, { id, ...data });
    }

    async function patch(id, data) {
        return await HttpClient.patch(`${fullURL}`, { id, ...data });
    }

    async function remove(id) {
        return await HttpClient.remove(`${fullURL}/${id}`);
    }

    return { getOne, getAll, post, put, patch, remove }
}

function URIBuilder(filters) {
    if (!filters || Object.keys(filters).length === 0) return '';
    return '?' + Object.entries(filters)
        .map(([k, v]) => {
            if (Array.isArray(v)) {
                return v.map(val => `&${k}[]=${encodeURIComponent(val)}`).join('');
            }
            return `&${k}=${encodeURIComponent(v)}`;
        }).join('');
}

function getFullURL(route) {
    return `${ROUTER_PATH}${route}`;
}