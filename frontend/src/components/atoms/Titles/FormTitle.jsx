import { Title } from '@mantine/core'

const FormTitle = ({ children }) => (
    <Title order={3} c='laplateforme.6' style={{ fontWeight: 700, marginBottom: '1rem' }}>
        {children}
    </Title>
)

export default FormTitle;