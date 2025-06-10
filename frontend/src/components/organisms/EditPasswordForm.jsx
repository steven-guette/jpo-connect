import { useState } from 'react'

import AuthService from '../../services/AuthService'
import Notifications from '../../utils/Notifications'

import BaseForm from '../molecules/BaseForm'
import PasswordInput from '../atoms/Inputs/PasswordInput'

const EditPasswordForm = ({ onSuccess }) => {
    const [newPassword, setNewPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const [currentPassword, setCurrentPassword] = useState('');
    const [error, setError] = useState(null);
    const [loading, setLoading] = useState(false);

    const handleSubmit = async(e) => {
        e.preventDefault();
        setLoading(true);
        setError(null);

        if (newPassword !== confirmPassword) {
            setError("Les mots de passe ne correspondent pas.");
            setLoading(false);
            return;
        }

        try {
            let updateResult = await AuthService.changePass(currentPassword, newPassword);
            if (!updateResult.success) {
                setError(updateResult.message);
                setLoading(false);
                return;
            }

            Notifications.Success("Votre mot de passe a été modifié.");

            updateResult = null;
            setCurrentPassword(null);
            setNewPassword(null);
            setConfirmPassword(null);

            if (onSuccess) onSuccess();
        } catch (err) {
            setError("Une erreur est survenue lors de la modification de votre mot de passe.");
            console.error(err.message);
        } finally {
            setLoading(false);
        }
    }

    return (
        <BaseForm
            title="Modification de votre mot de passe"
            onClose={() => setError(null)}
            onSubmit={handleSubmit}
            error={error}
            loading={loading}
            buttonText="Modifier"
        >
            <PasswordInput
                label="Ancien mot de passe"
                value={currentPassword}
                onChange={(e) => setCurrentPassword(e.currentTarget.value)}
                required
            />

            <PasswordInput
                label="Nouveau mot de passe"
                value={newPassword}
                onChange={(e) => setNewPassword(e.currentTarget.value)}
                required
            />

            <PasswordInput
                label="Confirmer le mot de passe"
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.currentTarget.value)}
                required
            />
        </BaseForm>
    )
}

export default EditPasswordForm;