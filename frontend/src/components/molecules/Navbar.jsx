import { Container, Box, Group} from '@mantine/core'
import { useAuth } from '../../contexts/AuthContext'
import { useNavigate } from 'react-router-dom'

import FormModal from '../atoms/Modals/FormModal.jsx'
import NavAnchor from '../atoms/Anchors/NavAnchor'
import PrimaryButton from '../atoms/Buttons/PrimaryButton'
import LogoutButton from '../molecules/LogoutButton'
import LoginForm from '../organisms/LoginForm'
import RegisterForm from '../organisms/RegisterForm'
import ModalManager from '../../utils/ModalManager.jsx'

const Navbar = () => {
    const loginModal = ModalManager();
    const registerModal = ModalManager();

    const navigate = useNavigate();
    const { isAuthenticated } = useAuth();

    return (
        <Box component='nav' bg='white' py='xl' shadow='xs'>
            <Container style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <NavAnchor to='/home' fw={700} fz='xl' c='laplateforme.6'>
                    La Plateforme
                </NavAnchor>

                <Group spacing='lg'>
                    <NavAnchor to='/about'>Notre école</NavAnchor>
                    <NavAnchor to='/location'>Où sommes nous</NavAnchor>
                    <NavAnchor to='/event'>JPO / Événements</NavAnchor>

                    {!isAuthenticated ? (
                        <>
                            <PrimaryButton variant='outline' size='xs' onClick={loginModal.open}>
                                Connexion
                            </PrimaryButton>
                            <PrimaryButton variant='outline' size='xs' onClick={registerModal.open}>
                                Inscription
                            </PrimaryButton>

                            <FormModal opened={loginModal.opened} onClose={loginModal.close}>
                                <LoginForm onSuccess={loginModal.close} />
                            </FormModal>

                            <FormModal opened={registerModal.opened} onClose={registerModal.close}>
                                <RegisterForm onSuccess={registerModal.close} />
                            </FormModal>
                        </>
                    ) : (
                        <>
                            <PrimaryButton variant='outline' size='xs' onClick={() => navigate('/account')}>
                                Mon compte
                            </PrimaryButton>
                            <LogoutButton />
                        </>
                    )}
                </Group>
            </Container>
        </Box>
    )
}

export default Navbar;