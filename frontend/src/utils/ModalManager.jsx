import { useDisclosure } from '@mantine/hooks'

function ModalManager() {
    const [opened, { open, close, toggle }] = useDisclosure(false);
    return { opened, open, close, toggle };
}

export default ModalManager;