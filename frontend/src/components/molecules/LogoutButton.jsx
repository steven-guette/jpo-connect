import SecondaryButton from '../atoms/Buttons/SecondaryButton'
import Notifications from '../../utils/Notifications.jsx'
import AuthService from '../../services/AuthService'

import { useAuth } from '../../contexts/AuthContext'
import { useNavigate } from 'react-router-dom'

const LogoutButton = () => {
	const { user, setUser } = useAuth();
	const navigate = useNavigate();

	const logout = async() => {
		if (!user) {
			Notifications.Warning("Vous n'êtes pas connecté à votre compte.");
			return;
		}

		try {
			const logoutResult = await AuthService.logout();
			if (logoutResult.success) {
				setUser(null);
				Notifications.Success(`Au revoir ${user.firstname}, à bientôt sur notre portail !`);
				navigate('/home');
			} else {
				Notifications.Error("Nous ne parvenons pas à vous déconnecter.");
			}
		} catch (err) {
			Notifications.Error("Nous ne parvenons pas à communiquer avec le serveur afin de vous déconnecter.")
			console.error(err);
		}
	}

	return (
		<SecondaryButton variant='outline' size='xs' onClick={logout}>
			Déconnexion
		</SecondaryButton>
	)
}

export default LogoutButton;