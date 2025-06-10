import { Container, Box, Text, Group } from '@mantine/core'
import LinkAnchor from '../atoms/Anchors/LinkAnchor'

const FooterAnchor = ({ to, ...props }) => (
    <LinkAnchor to={to} c='gray.3' fz='sm' {...props} />
)

const Footer = () => (
    <Box component='footer' py='xl' mt='xl' bg='grayblue.9'>
        <Container style={{ display: 'flex', justifyContent: 'space-between', color: 'white' }}>
            <Box>
                <Text fw={700}>La Plateforme_</Text>
                <Text fz="sm">© {new Date().getFullYear()} Tous droits réservés.</Text>
            </Box>
            <Group>
                <FooterAnchor to='/legal-notice'>Mentions légales</FooterAnchor>
                <FooterAnchor to='/contact'>Contact</FooterAnchor>
                <FooterAnchor to='/cgu'>CGU</FooterAnchor>
            </Group>
        </Container>
    </Box>
)

export default Footer