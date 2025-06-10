import Router from '../api/Router'

const controller = 'users'

const UsersService = {
    getOne:     id => Router(controller).getOne(id),
    getAll:     (filters = {}) => Router(controller).getAll(filters),
    create:     data => Router(controller).post(data),
    update:     (id, data) => Router(controller).patch(id, data),
    delete:     id => Router(controller).remove(id)
}

export default UsersService;