import Router from '../api/Router'

const AuthService = {
    changePass: (currentPassword, newPassword) => Router('auth/changePass').post({ currentPassword, newPassword }),
    login:      (email, password) => Router('auth/login').post({ email, password }),
    logout:     () => Router('auth/logout').getAll(),
    me:         () => Router('auth/me').getAll()
}

export default AuthService;