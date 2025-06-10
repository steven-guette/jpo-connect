import { createContext, useContext, useState, useEffect } from 'react'
import AuthService from '../services/AuthService'

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchUser = async () => {
            try {
                const userData = await AuthService.me();
                console.log('[AuthContext] userData:', userData)
                setUser(userData.success ? userData.data : null);
            } catch (err) {
                setUser(null);
                console.error(err);
            } finally {
                setLoading(false);
            }
        }
        fetchUser();
    }, []);

    return (
        <AuthContext.Provider value={{ user, setUser, loading, isAuthenticated: !!user }}>
            {children}
        </AuthContext.Provider>
    )
}

export const useAuth = () => useContext(AuthContext);