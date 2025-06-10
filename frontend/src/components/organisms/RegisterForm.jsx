import { useState } from 'react'
import { useAuth } from '../../contexts/AuthContext.jsx'

import UsersService from '../../services/UsersService.js'
import AuthService from '../../services/AuthService.js'
import Notifications from '../../utils/Notifications.jsx'

import TextInput from '../atoms/Inputs/TextInput.jsx'
import EmailInput from '../atoms/Inputs/EmailInput.jsx'
import PasswordInput from '../atoms/Inputs/PasswordInput.jsx'
import BaseForm from '../molecules/BaseForm.jsx'

const RegisterForm = ({ onSuccess }) => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');
    const [firstname, setFirstname] = useState('');
    const [name, setName] = useState('');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    const { setUser } = useAuth();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError(null);
        setLoading(true);

        if (password !== passwordConfirmation) {
            setError("Les mots de passe ne correspondent pas.");
            setLoading(false);
            return;
        }

        try {
            const registerResult = await UsersService.create({ email, password, firstname, name });
            if (!registerResult.success) {
                if (registerResult.status === 422) {
                    setError(registerResult.errors);
                } else {
                    setError("Une erreur est survenue lors de l'enregistrement de vos données personnelles.")
                    console.error(registerResult.errors);
                }

                setLoading(false);
                return;
            }

            const userData = await AuthService.login(email, password);
            if (!userData.success) {
                Notifications.Error("Nous ne parvenons pas à récupérer vos données personnelles.");
                console.error(userData.errors);
            } else {
                setUser(userData.data);
                Notifications.Success(`Bonjour ${userData.data.firstname}, bienvenue sur notre portail !`);
            }
            console.log(registerResult, userData);

            if (onSuccess) onSuccess();
        } catch (err) {
            setError("Nous ne parvenons pas à traiter votre demande d'inscription.");
            console.error(err.message);
        } finally {
            setLoading(false);
        }
    }

    return (
        <BaseForm
            title="Inscription"
            onClose={() => setError(null)}
            onSubmit={handleSubmit}
            error={error}
            loading={loading}
            buttonText="S'inscrire"
        >
                <TextInput
                    label='Prénom'
                    placeholder='Steven'
                    value={firstname}
                    disabled={loading}
                    onChange={(e) => setFirstname(e.currentTarget.value)}
                    required
                />

                <TextInput
                    label='Nom'
                    placeholder='Guette'
                    value={name}
                    disabled={loading}
                    onChange={(e) => setName(e.currentTarget.value)}
                    required
                />

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

                <PasswordInput
                    label='Confirmation du mot de passe'
                    disabled={loading}
                    onChange={(e) => setPasswordConfirmation(e.currentTarget.value)}
                    required
                />
        </BaseForm>
    );
}

export default RegisterForm;