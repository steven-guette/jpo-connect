import { useState } from 'react'
import { useAuth } from '../../contexts/AuthContext.jsx'

import AuthService from '../../services/AuthService.js'
import Notifications from '../../utils/Notifications.jsx'

import EmailInput from '../atoms/Inputs/EmailInput.jsx'
import PasswordInput from '../atoms/Inputs/PasswordInput.jsx'
import BaseForm from '../molecules/BaseForm.jsx'

const LoginForm = ({ onSuccess }) => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    const { setUser } = useAuth();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError(null);
        setLoading(true);

        try {
            const loginResult = await AuthService.login(email, password);
            if (!loginResult.success) {
                if (loginResult.status === 401) {
                    setError(loginResult.message);
                } else {
                    setError("Une erreur est survenue lors de la connexion.");
                    console.error(loginResult.errors);
                }

                setLoading(false);
                return;
            }

            setUser(loginResult.data);
            Notifications.Success(`Bonjour ${loginResult.data.firstname}, cela fait plaisir de vous revoir sur notre portail !`);
            console.log(loginResult);

            if (onSuccess) onSuccess();
        } catch (err) {
            setError("Nous ne parvenons pas à traiter votre demande de connexion.");
            console.error(err.message);
        } finally {
            setLoading(false);
        }
    }

    return (
        <BaseForm
            title="Connexion"
            onClose={() => setError(null)}
            onSubmit={handleSubmit}
            error={error}
            loading={loading}
            buttonText="Se connecter"
        >
                <EmailInput
                    value={email}
                    disabled={loading}
                    onChange={(e) => setEmail(e.currentTarget.value)}
                    required
                />

                <PasswordInput
                    value={password}
                    disabled={loading}
                    onChange={(e) => setPassword(e.currentTarget.value)}
                    required
                />
        </BaseForm>
    );
}

export default LoginForm;