import { useAuth } from '../../../contexts/AuthContext'
import { Navigate } from 'react-router-dom'

const PrivateRoute = ({ children }) => {
    const { isAuthenticated, loading } = useAuth();

    if (loading) return null;
    return isAuthenticated ? children : <Navigate to='/home' replace />;
}

export default PrivateRoute;