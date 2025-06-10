import { useState } from 'react'
import { useAuth } from '../../contexts/AuthContext.jsx'

import UsersService from '../../services/UsersService'
import AuthService from '../../services/AuthService'

import Notifications from '../../utils/Notifications'
import TextInput from '../atoms/Inputs/TextInput'
import EmailInput from '../atoms/Inputs/EmailInput'
import BaseForm from '../molecules/BaseForm'

const EditProfilForm = ({ onSuccess }) => {
    const { user, setUser } = useAuth();

    const [firstname, setFirstname] = useState(user.firstname);
    const [name, setName] = useState(user.name);
    const [email, setEmail] = useState(user.email);
    const [loading, setLoading] = useState(false);

    const handleSubmit = async(e) => {
        e.preventDefault();
        setLoading(true);

        let toUpdate = { roleId: user.roleId };
        if (firstname !== user.firstname)   toUpdate.firstname = firstname;
        if (name !== user.name)             toUpdate.name = name;
        if (email !== user.email)           toUpdate.email = email;

        if (Object.keys(toUpdate).length === 0) {
            setLoading(false);
            return;
        }

        try {
            const updateResult = await UsersService.update(user.id, { ...toUpdate });
            if (!updateResult.success) {
                if (updateResult.status === 422) {
                    Notifications.Error(updateResult.errors);
                } else {
                    Notifications.Error(updateResult.message);
                    console.error(updateResult.errors);
                }

                setLoading(false);
                return;
            }

            const userData = await AuthService.me();
            if (!userData.success) {
                Notifications.Error(userData.message);
                console.error(userData.errors);
                setLoading(false);
                return;
            }

            Notifications.Success("Vos données ont été modifiées avec succès.");
            setUser(userData.data);

            if (onSuccess) onSuccess();
        } catch (err) {
            Notifications.Error("Nous ne parvenons pas à modifier vos données.")
            console.log(err.message);
        } finally {
            setLoading(false);
        }
    }

    return (
        <BaseForm
            title="Modifier mon profil"
            onClose={() => setLoading(false)}
            onSubmit={handleSubmit}
            error={null}
            loading={loading}
            buttonText="Modifier"
            canCancel={true}
            cancelEvent={onSuccess}
        >
            <TextInput
                label='Prénom'
                placeholder={user.firstname}
                value={firstname}
                disabled={loading}
                onChange={(e) => setFirstname(e.currentTarget.value)}
                required
            />

            <TextInput
                label='Nom'
                placeholder={user.name}
                value={name}
                disabled={loading}
                onChange={(e) => setName(e.currentTarget.value)}
                required
            />

            <EmailInput
                placeholder={user.email}
                value={email}
                disabled={loading}
                onChange={(e) => setEmail(e.currentTarget.value)}
                required
            />
        </BaseForm>
    )
}

export default EditProfilForm;