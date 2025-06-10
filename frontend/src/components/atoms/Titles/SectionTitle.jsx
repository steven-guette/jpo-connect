import { Title, useMantineTheme } from '@mantine/core'

const SectionTitle = ({ children, style = {}, ...props }) => {
    const theme = useMantineTheme();
    return (
        <Title order={3} mb="sm" style={{ color: theme.colors[theme.primaryColor][9], ...style }} {...props}>
            {children}
        </Title>
    )
}

export default SectionTitle;