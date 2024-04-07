

contract AcademicRecords {
    // Definición de la clase StudentRecord
    struct StudentRecord {
        string studentName;
        uint256[] grades;
        address school;
    }
    
    // Mapeo de direcciones de estudiantes a sus registros académicos
    mapping(address => StudentRecord) public studentRecords;
    
    // Función para añadir un nuevo registro académico
    function addAcademicRecord(string memory _studentName, uint256[] memory _grades) public {
        // Crear una instancia de StudentRecord
        StudentRecord storage newRecord = studentRecords[msg.sender];
        // Asignar los valores a la nueva instancia
        newRecord.studentName = _studentName;
        newRecord.grades = _grades;
        newRecord.school = msg.sender;
    }
    
    // Función para obtener los registros académicos de un estudiante
    function getAcademicRecord(address _studentAddress) public view returns(string memory, uint256[] memory) {
        return (studentRecords[_studentAddress].studentName, studentRecords[_studentAddress].grades);
    }
}

