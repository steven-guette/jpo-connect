import Router from '../api/Router'

const controller = 'Registrations';

const RegistrationsService = {
    getOne:     id => Router(controller).getOne(id),
    getAll:     (filters = {}) => Router(controller).getAll(filters),
    create:     data => Router(controller).post(data),
    update:     (id, data) => Router(controller).put(id, data),
    delete:     id => Router(controller).remove(id)
}

export default RegistrationsService;
